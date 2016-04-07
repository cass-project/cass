<?php
namespace Data\Exception;

/**
 * Don't use doctrine2's EntityNotFound exception in middleware or services
 *
 * You have been warned.
 */

class DataEntityNotFoundException extends \Exception {}