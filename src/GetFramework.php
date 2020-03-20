<?php


namespace ErrorTransmitting;


use ErrorTransmitting\Drive\Think;
use ErrorTransmitting\Exception\DriveNotFindException;
use ErrorTransmitting\Handler\Handler;

class GetFramework
{

    private $drive = [
        'Think' => Think::class
    ];
    //框架名称
    private $frameworkName;
    //框架核心组件
    private $framework;
    private static $instance;

    private function __construct()
    {

    }

    /**
     * 查询驱动是否存在
     * @return Handler
     * @throws DriveNotFindException
     */
    public function get()
    {
        return $this->searchFramework();
    }

    public static function create()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *  判断框架的大体类型
     */
    private function searchFramework()
    {
        //查询是否是thinkphp 框架
        if (class_exists(\think\App::class)) {
            $this->frameworkName = 'Think';
            $this->framework = \think\App::class;
        }
        if (!isset($this->drive[$this->frameworkName])) {
            throw new DriveNotFindException(' not find drive');
        } else {
            $classSpace = $this->drive[$this->frameworkName];
        }
        //加载框架驱动
        $classSpace = new $classSpace();
        $framework = $classSpace->load($this->framework);
        return $framework;
    }
}