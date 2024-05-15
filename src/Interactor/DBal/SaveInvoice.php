<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use Exception;
use IamPersistent\Money\Interactor\MoneyToJson;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\Paid;
use IamPersistent\SimpleShop\Interactor\ObjectHasId;
use IamPersistent\SimpleShop\Interactor\SaveInvoiceInterface;

final class SaveInvoice extends DBalCommon implements SaveInvoiceInterface
{
    /** @var \IamPersistent\SimpleShop\Interactor\DBal\SaveInvoiceItem */
    private $saveItem;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->saveItem = new SaveInvoiceItem($connection);
    }

    public function save(Invoice $invoice): bool
    {
        if ($invoice->getId()) {
            return $this->updateData($invoice);
        }

        return $this->insertData($invoice);
    }

    private function getItemsToDelete(Invoice $invoice)
    {
        $invoiceId = (int) $invoice->getId();
        foreach ($invoice->getItems() as $item) {
            if ($id = $item->getId()) {
                $ids[] = $item->getId();
            }
        }
        if (empty($ids)) {
            return false;
        }
        $activeIds = implode(',', $ids);

        return <<<SQL
DELETE FROM invoice_items
WHERE invoice_id = $invoiceId
AND id NOT IN ($activeIds)
SQL;
    }

    private function insertData(Invoice $invoice): bool
    {
        $this->connection->beginTransaction();

        try {
            $data = $this->prepDataForPersistence($invoice);

            $response = $this->connection->insert('invoices', $data);
            if (1 === $response) {
                $id = $this->connection->lastInsertId();
                $invoice->setId($id);
            } else {
                $this->connection->rollBack();

                return false;
            }
            $this->saveInvoiceItems($invoice);

        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        $this->connection->commit();

        return true;
    }

    private function updateData(Invoice $invoice): bool
    {
        $this->connection->beginTransaction();

        try {
            $data = $this->prepDataForPersistence($invoice);

            $response = $this->connection->update('invoices', $data, ['id' => $invoice->getId()]);

            $this->saveInvoiceItems($invoice);

        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        $this->connection->commit();

        return true;
    }

    private function prepDataForPersistence(Invoice $invoice): array
    {
        $moneyToJson = (new MoneyToJson());

        $paidId = $this->savePaid($invoice->getPaid());

        return [
            'currency'       => $invoice->getCurrency(),
            'entrant_id'     => $invoice->getEntrantId(),
            'header'         => $invoice->getHeader(),
            'invoice_date'   => $invoice->getInvoiceDate()->format('Y-m-d'),
            'invoice_number' => $invoice->getInvoiceNumber(),
            'recipient_id'   => $invoice->getRecipientId(),
            'paid_id'        => $paidId,
            'subtotal'       => $moneyToJson($invoice->getSubtotal()),
            'tax_rate'       => $invoice->getTaxRate(),
            'taxes'          => $moneyToJson($invoice->getTaxes()),
            'total'          => $moneyToJson($invoice->getTotal()),
        ];
    }

    private function saveInvoiceItems(Invoice $invoice)
    {
        if ($sql = $this->getItemsToDelete($invoice)) {
            $this->connection->exec($sql);
        }

        foreach ($invoice->getItems() as $item) {
            $this->saveItem->save($invoice, $item);
        }
    }

    private function savePaid(Paid $paid = null): ?int
    {
        if (null === $paid) {
            return null;
        }

        if ($id = $paid->getId()) {
            return $id;
        }

        $moneyToJson = (new MoneyToJson());

        $data = [
            'amount'              => $moneyToJson($paid->getAmount()),
            'authorization_code'  => $paid->getAuthorizationCode(),
            'date'                => $paid->getDate()->format('Y-m-d'),
            'payment_method_id'   => $paid->getPaymentMethod()->getId(),
            'payment_method_type' => $paid->getPaymentMethod()->getPaymentMethodType(),
        ];
        $response = $this->connection->insert('invoice_paid', $data);
        if (1 !== $response) {
            throw new Exception('There was a problem persisting the payment information');
        }
        $paidId = (int) $this->connection->lastInsertId();
        $paid->setId($paidId);

        return $paidId;
    }
}
