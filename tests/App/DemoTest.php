<?php

namespace Test\App;

use App\App\Demo;
use App\Util\HttpRequest;
use PHPUnit\Framework\TestCase;


class DemoTest extends TestCase
{

    public function test_foo()
    {
        $demo = $this->getMockBuilder(Demo::class)
            ->disableOriginalConstructor()
            ->onlyMethods([]) //需要mock的方法为空，表示其他方法都不需要mock
            ->getMock();
        $foo = $demo->foo();
        $this->assertEquals("bar",$foo);
    }

    public function test_get_user_info()
    {
        $stub = $this->createStub(HttpRequest::class);
        $stub->method("get")->willReturn('{
            "error":0,
            "data":{
                "id":1,
                "username":"hello world"
            }
        }');

        $demo = $this->getMockBuilder(Demo::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $demo->set_req($stub);
        $user_info = $demo->get_user_info();
        $expected = ["id"=>1,"username"=>"hello world"];
        $this->assertEquals($expected,$user_info);
    }
}
