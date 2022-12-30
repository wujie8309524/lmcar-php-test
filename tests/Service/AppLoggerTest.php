<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;

/**
 * Class ProductHandlerTest
 */
class AppLoggerTest extends TestCase
{

    private $testLogPath;
    public function setUp():void
    {
        $this->testLogPath = sprintf("./logs/%s/%s_cli.log",date("Ym"),date("d"));
        if(file_exists($this->testLogPath)) {
            unlink($this->testLogPath);
            rmdir(dirname($this->testLogPath));
        }
    }

    public function tearDown():void
    {
        if(file_exists($this->testLogPath)) {
            unlink($this->testLogPath);
            rmdir(dirname($this->testLogPath));
        }
    }

    public function testInfoLog()
    {
        $logger = new AppLogger('log4php');
        //测试控制台是否输出字符串
        $this->expectOutputRegex("/This is info log message/");
        $logger->info('This is info log message');


        $logger = new AppLogger('think-log');
        $logger->getLogger()->init([
            'default'      => 'file',
            'channels'    =>    [
                'file'    =>    [
                    'type'          => 'file',
                    'path'          => './logs/',
                ],
            ],
        ]);
        $logger->info("This is info log message");
        //测试是否创建了日志文件
        $this->assertTrue(file_exists($this->testLogPath));
        $msgContent = file_get_contents($this->testLogPath);
        //测试日志内容是否大写
        $this->assertMatchesRegularExpression(
            "/THIS IS INFO LOG MESSAGE/",
            $msgContent
        );
        //测试日志级别
        $this->assertMatchesRegularExpression(
            "/\[info\]/",
            $msgContent
        );
    }

    public function testDebugLog()
    {
        $logger = new AppLogger('log4php');
        //测试控制台是否输出字符串
        $this->expectOutputRegex("/This is debug log message/");
        $logger->debug('This is debug log message');


        $logger = new AppLogger('think-log');
        $logger->getLogger()->init([
            'default'      => 'file',
            'channels'    =>    [
                'file'    =>    [
                    'type'          => 'file',
                    'path'          => './logs/',
                ],
            ],
        ]);
        $logger->debug("This is debug log message");
        //测试是否创建了日志文件
        $this->assertTrue(file_exists($this->testLogPath));
        $msgContent = file_get_contents($this->testLogPath);
        //测试日志内容是否大写
        $this->assertMatchesRegularExpression(
            "/THIS IS DEBUG LOG MESSAGE/",
            $msgContent
        );
        //测试日志级别
        $this->assertMatchesRegularExpression(
            "/\[debug\]/",
            $msgContent
        );
    }

    public function testErrorLog()
    {
        $logger = new AppLogger('log4php');
        //测试控制台是否输出字符串
        $this->expectOutputRegex("/This is error log message/");
        $logger->error('This is error log message');


        $logger = new AppLogger('think-log');
        $logger->getLogger()->init([
            'default'      => 'file',
            'channels'    =>    [
                'file'    =>    [
                    'type'          => 'file',
                    'path'          => './logs/',
                ],
            ],
        ]);
        $logger->error("This is error log message");
        //测试是否创建了日志文件
        $this->assertTrue(file_exists($this->testLogPath));
        $msgContent = file_get_contents($this->testLogPath);
        //测试日志内容是否大写
        $this->assertMatchesRegularExpression(
            "/THIS IS ERROR LOG MESSAGE/",
            $msgContent
        );
        //测试日志级别
        $this->assertMatchesRegularExpression(
            "/\[error\]/",
            $msgContent
        );
    }
}