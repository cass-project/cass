<?php
namespace Feed\Feed;

interface Query
{
    public function execute() /* ResultSet || array ! */;
}