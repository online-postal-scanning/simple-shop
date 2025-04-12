<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use OLPS\Money\JsonToMoney;
use OLPS\SimpleShop\Entity\BalanceAdjustment;
use OLPS\SimpleShop\Entity\Cash;
use OLPS\SimpleShop\Entity\Check;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\MoneyOrder;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Entity\PaymentMethodInterface;
use OLPS\SimpleShop\Entity\Unknown;

final class HydratePaid
{
    public function __invoke(array $paidData): Paid
    {
        $date = $paidData['date'] ? new DateTime($paidData['date']) : null;
        $amount = (new JsonToMoney())($paidData['amount']);
        $paymentMethod = $this->getPaymentMethod($paidData);

        return (new Paid())
            ->setAmount($amount)
            ->setAuthorizationCode($paidData['authorization_code'])
            ->setDate($date)
            ->setId($paidData['id'])
            ->setPaymentMethod($paymentMethod);
    }

    private function getPaymentMethod(array $paidData): PaymentMethodInterface
    {
        $method = 'get'.ucfirst($paidData['payment_method_type']);

        return $this->$method($paidData);
    }

    private function getBalanceAdjustment(array $paidData): BalanceAdjustment
    {
        return (new BalanceAdjustment());
    }

    private function getCash(array $paidData): Cash
    {
        return (new Cash());
    }

    private function getCheck(array $paidData): Check
    {
        $data = [
            'check_number' => $paidData['check_number'],
            'date'         => $paidData['date'],
            'id'           => $paidData['id'],
        ];

        return (new HydrateCheck())($data);
    }

    private function getCreditCard(array $paidData): CreditCard
    {
        $data = [
            'is_active'       => $paidData['is_active'],
            'brand'           => $paidData['brand'],
            'card_number'     => $paidData['last_four'],
            'card_reference'  => $paidData['card_reference'],
            'city'            => $paidData['city'],
            'country'         => $paidData['country'],
            'expiration_date' => $paidData['expiration_date'],
            'id'              => $paidData['id'],
            'last_four'       => $paidData['last_four'],
            'owner_id'        => $paidData['owner_id'],
            'name_on_card'    => $paidData['name_on_card'],
            'post_code'       => $paidData['post_code'],
            'state'           => $paidData['state'],
            'street_1'        => $paidData['street_1'],
            'street_2'        => $paidData['street_2'],
            'title'           => $paidData['title'],
        ];

        return (new HydrateCreditCard())($data);
    }

    private function getMoneyOrder(array $paidData): MoneyOrder
    {
        $data = [
            'date'          => $paidData['date'],
            'id'            => $paidData['id'],
            'serial_number' => $paidData['serial_number'],
        ];

        return (new HydrateMoneyOrder())($data);
    }

    private function getUnknown(array $paidData): Unknown
    {
        return (new Unknown());
    }
}
