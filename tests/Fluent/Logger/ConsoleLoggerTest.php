<?php

namespace FluentTests\Logger;

use Fluent\Logger;
use Fluent\Logger\ConsoleLogger;

class ConsoleLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testOpenMethod()
    {
        $fp = fopen("php://memory","r+w");
        $logger = ConsoleLogger::open($fp);
        $this->assertInstanceof('Fluent\\Logger', $logger, 'Logger::open should return Logger instance ');
        fclose($fp);
    }
    
    public function testPostMethod()
    {
        $fp = fopen("php://memory","r+");
        $logger = ConsoleLogger::open($fp);
        $logger->post("debug.test",array("a"=>"b"));
        fseek($fp,0);
        $data = stream_get_contents($fp);
        $this->assertTrue((bool)preg_match("/debug.test\t\{\"a\":\"b\"\}/",$data),
            "ConsoleLogger::post could not write correctly.\nresult: {$data}");
        fclose($fp);
    }
}
