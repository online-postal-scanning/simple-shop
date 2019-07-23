<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Interactor\FindInvoiceByIdInterface;

final class FindInvoiceById extends DBalCommon implements FindInvoiceByIdInterface
{
    public function find($id): ?Invoice
    {
        $sql = $this->sql($id);
        $statement = $this->connection->executeQuery($sql);
        $invoiceData = $statement->fetch();
        if (empty($invoiceData)) {
            return null;
        }
        $invoiceData['items'] = $this->getItemData($id);

        return (new HydrateInvoice())($invoiceData);
    }

    private function getItemData($invoiceId): array
    {
        $sql = <<<SQL
SELECT 
   i.*,
   p.active,
   p.created_at,
   p.description AS product_description,
   p.name,
   p.price,
   p.taxable,
   p.updated_at
FROM invoice_items AS i
LEFT JOIN products AS p ON p.id = i.product_id
WHERE invoice_id = $invoiceId
SQL;
        $data = $this->connection->fetchAll($sql);

        return $this->prepareItems($data);
    }

    private function prepareItems(array $data): array
    {
        $items = [];
        foreach ($data as $datum) {
            $items[] = [
                'amount'       => $datum['amount'],
                'description'  => $datum['description'],
                'id'           => $datum['id'],
                'is_taxable'   => $datum['is_taxable'],
                'product'      => [
                    'active'      => $datum['active'],
                    'created_at'  => $datum['created_at'],
                    'description' => $datum['product_description'],
                    'id'          => $datum['product_id'],
                    'name'        => $datum['name'],
                    'price'       => $datum['price'],
                    'taxable'     => $datum['taxable'],
                    'updated_at'  => $datum['updated_at'],
                ],
                'quantity'     => $datum['quantity'],
                'total_amount' => $datum['total_amount'],
            ];
        }

        return $items;
    }

    private function sql($id): string
    {
        return <<<SQL
SELECT 
    i.*,
    p.amount,
    p.authorization_code,
    p.date,
    p.payment_method_id,
    p.payment_method_type,
    c.check_number,
    cc.card_reference,
    cc.last_four,
    cc.card_reference,
    cc.brand,
    cc.expiration_date,
    cc.owner_id,
    cc.title,
    mo.date AS moneyOrderDate,
    mo.serial_number
FROM invoices AS i
LEFT JOIN invoice_paid AS p ON p.id = i.paid_id
LEFT JOIN checks AS c ON p.payment_method_id = c.id
LEFT JOIN credit_cards AS cc ON p.payment_method_id = cc.id
LEFT JOIN money_orders AS mo ON p.payment_method_id = mo.id
WHERE i.id = $id;
SQL;
    }
}
