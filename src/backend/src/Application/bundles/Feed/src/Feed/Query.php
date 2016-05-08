<?php
namespace Application\Feed\Feed;

interface Query
{
    public function execute() /* ResultSet || array ! */;
}