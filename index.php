<?php

require __DIR__ . '/vendor/autoload.php';


use Discord\Discord;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use Discord\Parts\User\Member;
use Discord\Parts\Channel\Message;
use Application\Controllers\MainController;
use Application\Config\Config;


$ds = new Discord( [
    'token' => Config::TOKEN,
    'intents' => Intents::getDefaultIntents()
] );


$ds->on( 'ready', function( $ds )
{

    $ds->on( Event::MESSAGE_CREATE, function( Message $msg, Discord $ds)
    {

        if ($msg->author->bot) return;

        if(MainController::checkAuth($msg->author->id, $msg->guild_id)['code'] == 201) {
            $msg->reply( $msg->author->username . ", вы успешно авторизовались в системе!");
        }


        switch (strtolower($msg->content)) {
            case Config::TAG . 'help':

                $msg->reply($msg->author->username . ", держи список основных команд:\n\n- " . Config::TAG . "info - просмотр профиля;");

                break;

            case Config::TAG . 'info':
                
                $data = MainController::getUserInfo($msg->author->id)['data'];
                $user_roles = "";
                    
                foreach ($msg->member->roles as $value) {
                    $user_roles .= "- " . $value->name . ";\n";
                }

                if($user_roles) {
                    $user_roles = "\n\nРоли:\n" . $user_roles;
                }

                $msg->reply($msg->author->username . ", ваш профиль: \n\nКоличество сообщений на сервере: " . $data['message_count'] . $user_roles);

                break;
        }

    } );

    $ds->on( Event::GUILD_MEMBER_ADD, function( Member $member, Discord $ds )
    {

        $member->addRole( '1007995229674156102' );
        $member->setNickname( 'Новый никнейм' );

    } );


} );


$ds->run();