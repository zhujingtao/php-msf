<?php
/**
 * Queue Redis
 * @author camera360_server@camera360.com
 * @copyright Chengdu pinguo Technology Co.,Ltd.
 * Date: 26/10/2017
 */

namespace PG\MSF\Queue;

use PG\MSF\Base\Core;

class Redis extends Core implements IQueue
{
    /** @var  \Redis */
    public $redis;

    /**
     * Queue Redis constructor.
     * @param string $redisName redis连接池名称
     * @param bool $isProxy 是否是代理
     */
    public function __construct(string $redisName, bool $isProxy = true)
    {
        $this->redis = $isProxy ? $this->getRedisProxy($redisName) : $this->getRedisPool($redisName);
    }

    /**
     * 入队
     * @param string $queue 队列名称
     * @param $data
     * @return int
     */
    public function set(string $queue, $data)
    {
        return $this->redis->rPush($queue, $data);
    }

    /**
     * 出队
     * @param string $queue 队列名称
     * @return string
     */
    public function get(string $queue)
    {
        return $this->redis->lPop($queue);
    }

    /**
     * 队列当前长度
     * @param string $queue
     * @return int
     */
    public function len(string $queue)
    {
        return $this->redis->lLen($queue);
    }
}
