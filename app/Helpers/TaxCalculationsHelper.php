<?php
/**
 * Created by PhpStorm.
 * User: malak
 * Date: 12/16/18
 * Time: 12:34 AM
 */

namespace App\Helpers;

/**
 * Class TaxCalculationsHelper
 * @package App\Helpers
 */
class TaxCalculationsHelper
{
    const TAX_EXEMPTION = 9000;
    const RESIDENT_FIRST_TAX_PERCENTAGE = 0.1;
    const RESIDENT_FIRST_TAX_PERCENTAGE_EXEMPTION = 10000;
    const GENERAL_TAX_PERCENTAGE = 0.2;

    /**
     * @param int $income
     * @param bool $resident
     * @return float|int
     */
    static function calculate(int $income = 0, bool $resident = false)
    {
        if ($income <= self::TAX_EXEMPTION) {
            return 0;
        }

        $tax = 0;
        $taxedIncome = $taxedIncomeStage1 = $income - self::TAX_EXEMPTION;
        if ($resident) {
            if ($taxedIncome >= self::RESIDENT_FIRST_TAX_PERCENTAGE_EXEMPTION) {
                $taxedIncomeStage1 = self::RESIDENT_FIRST_TAX_PERCENTAGE_EXEMPTION;
            }
            $tax += self::RESIDENT_FIRST_TAX_PERCENTAGE * $taxedIncomeStage1;
            $taxedIncome -= $taxedIncomeStage1;
        }
        $tax += $taxedIncome * self::GENERAL_TAX_PERCENTAGE;
        return $tax;
    }

    /**
     * @param int $income
     * @param bool $resident
     * @param bool $isMarried
     * @param int $spouseIncome
     * @param bool $spouseResident
     * @return array
     */
    static function calculateForTaxPayer(int $income = 0, bool $resident = false, $isMarried = false, int $spouseIncome = 0, bool $spouseResident = false)
    {
        $tax = self::calculate($income, $resident);
        $spouseTax = ($isMarried) ? self::calculate($spouseIncome, $spouseResident) : null;

        return [
            'tax' => $tax,
            'spouse_tax' => $spouseTax,
            'is_married' => $isMarried
        ];
    }

}
