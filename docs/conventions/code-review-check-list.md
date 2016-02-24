Code Review Check List
======================

PHP
===

Instant reject:
---------------
- Наличие `isset($arr['foo']) ? $arr['foo'] : null` вместо Null Coalesce Operator

- Наличие `try { ... }catch(\Exception $e){ ... }`

- Doctrine2-код вне репозиториев и сущностей.

98% reject:
-----------

- Наличие оператора `switch` вне фабрик