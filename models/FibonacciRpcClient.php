<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/4/28
 * Time: 14:20
 */

namespace app\models;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class FibonacciRpcClient
{
    private $connection;
//    private $host;
//    private $port;
//    private $user;
//    private $psd;
//    private $vhost;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct( $host, $port, $user, $psd, $vhost ){
        $this->connection = new AMQPStreamConnection($host,$port,$user,$psd,$vhost);
        $this->channel = $this->connection->channel();
        list($this->callback_queue,,) = $this->channel->queue_declare("",false,false,true,false);
        $this->channel->basic_consume($this->callback_queue,'',false,false,false,false,array($this,'on_response'));
    }

    public function on_rsponse($rep){
        if( $rep->get('correlation_id') == $this->corr_id ){
            $this->response = $rep->body;
        }
    }

    public function call($n){
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            (string) $n,
                array(
                    'correlation_id' => $this->corr_id,
                    'reply_to' => $this->callback_queue
                )
        );
        $this->channel->basic_publish($msg,'','rpc_queue');
        while(!$this->response){
            $this->channel->wait();
        }

        return intval($this->response);
    }

}