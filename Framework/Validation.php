<?php

  namespace Framework;

  class Validation {

    /**
     * Validates if the given value is a string within the specified length range.
     *
     * Trims the value and checks if its length is between the minimum and maximum bounds.
     *
     * @param mixed $value The value to validate.
     * @param int $min The minimum length of the string.
     * @param int $max The maximum length of the string.
     * @return bool Returns true if the value is a string within the specified range, false otherwise.
     */

    public static function string($value, $min = 1, $max = INF) {
      if (is_string($value)) {
        $value = trim($value);
        $length = strlen($value);

        return $length >= $min && $length <= $max;
      }
    }

    /**
     * Validates if the given value is a valid email address.
     *
     * Trims the value and uses the built-in filter_var function to validate the email.
     *
     * @param mixed $value The value to validate.
     * @return bool Returns true if the value is a valid email address, false otherwise.
     */
    public static function email($value) {
      $value = trim($value);

      return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    public static function match($value1, $value2) {
      $value1 = trim($value1);
      $value2 = trim($value2);

      return $value1 === $value2;
    }
  }
