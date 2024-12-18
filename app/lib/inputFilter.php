<?php

namespace inventory\lib;

use DateTime;

trait inputFilter
{
    private function applyFilter($input, int $filter, callable $validate): mixed
    {
        $filtered = filter_var($input, $filter);
        return $validate($filtered) ? $filtered : null;
    }

    public function filterInt($input): ?int
    {
        if (is_numeric($input) && (int)$input >= 0 && (int)$input <= 3000000) {
            return (int)$input;
        }
        return null;
    }


    public function filterFloat($input): ?float
    {
        return $this->applyFilter(
            $input,
            FILTER_SANITIZE_NUMBER_FLOAT,
            fn($filtered) => is_numeric($filtered) && (float)$filtered > 0
        );
    }

    public function filterString(string $input, int $minLength = 1, int $maxLength = 150): ?string
    {
        $filtered = htmlentities(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
        return (strlen($filtered) >= $minLength && strlen($filtered) <= $maxLength) ? $filtered : null;
    }

    public function filterEmail(string $input): ?string
    {
        return $this->applyFilter(
            trim($input),
            FILTER_SANITIZE_EMAIL,
            fn($filtered) => filter_var($filtered, FILTER_VALIDATE_EMAIL)
        );
    }

    public function filterUrl(string $input): ?string
    {
        return $this->applyFilter(
            trim($input),
            FILTER_SANITIZE_URL,
            fn($filtered) => filter_var($filtered, FILTER_VALIDATE_URL)
        );
    }

    public function filterDate(string $input): ?string
    {
        $filtered = trim($input);

        $date = DateTime::createFromFormat('Y-m-d', $filtered);

        return $date && $date->format('Y-m-d') === $filtered ? $filtered : null;
    }

    public function filterBoolean($input): bool
    {
        return filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    }

    private function validAge($dateOfBirth, $minAge)
    {
        $dob = new DateTime($dateOfBirth);
        $today = new DateTime();
        $age = $today->diff($dob)->y;

        return $age >= $minAge;
    }


    public function filterIntArray(array $inputArray): ?array
    {
        return $this->filterArray($inputArray, fn($item) => $this->filterInt($item));
    }

    public function filterFloatArray(array $inputArray): ?array
    {
        return $this->filterArray($inputArray, fn($item) => $this->filterFloat($item));
    }

    private function filterArray(array $inputArray, callable $filterFunc): ?array
    {
        $filteredArray = array_filter(array_map($filterFunc, $inputArray), fn($value) => $value !== null);
        return count($filteredArray) === count($inputArray) ? $filteredArray : null;
    }
}
