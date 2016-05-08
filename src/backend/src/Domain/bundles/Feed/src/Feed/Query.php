<?php
namespace Domain\Feed\Feed;

interface Query
{
    public function execute() /* ResultSet || array ! */;
}