<?php


if(isset($_POST['action_form']) && $_POST['action_form'] == 'login'){
    login($_POST['user'], $_POST['psw']);
}

//metodo para fazer login no equipamento
function login($user = 'admin', $psw = 'admin') {

    $data = [
        'login' => $user,
        'password' => $psw
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://192.168.1.7/login.fcgi",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    if($response === FALSE){
        $retorno = array(
           'codigo' => 500,
           'hideDiv' => false,
           'status' => false
        );
    } else {
        $responseData = json_decode($response, TRUE);
    
        if(!empty($responseData['session'])) {

            $retorno = array(
                'codigo' => 200,
                'status' => true,
                'hideDiv' => false,
                'messagem' => 'login realizado com sucesso!',
                'redirect' => '/configure_device.php?&session='.$responseData['session'],
                'session' => $responseData['session']
            );
           
        } else {
            
            $retorno = array(
                'codigo' => 501,
                'status' => false,
                'hideDiv' => false,
                'error' => $responseData
            );
        }
    
    }
  
    echo json_encode($retorno);
}

if(isset($_POST['action_form']) && $_POST['action_form'] == 'devices'){
    
    createObjects($_REQUEST['server'], $_REQUEST['ip'], $_REQUEST['public_key'], $_REQUEST['session']);
}

// metodo para criar um objeto device
// (esse objeto criado será a representação do servidor no equipamento)
function createObjects($serveName, $addressIP, $public_key, $session) {
    
    if(empty($session)) {
        $retorno = array(
            'codigo' => 501,
            'status' => false,
            'hideDiv' => false,
            'mesagem' => 'Não há sessão ativa, é necessário realizar login para continuar',
            'error' => $responseData
        );
    } else {

        $data = array(
            "object" => "devices",
            "values" => array(array(
                "name" => $serveName,
                "ip" => $addressIP,
                "public_key" => $public_key
            ))
        );
        

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.168.1.7/create_objects.fcgi?session=".$session,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        if($response === FALSE){
            $retorno = array(
               'codigo' => 500,
               'hideDiv' => false,
               'status' => false
            );
        } else {
            $responseData = json_decode($response, TRUE);
        
            if(!empty($responseData['ids'])) {
    
                $retorno = array(
                    'codigo' => 200,
                    'status' => true,
                    'hideDiv' => false,
                    'messagem' => 'Configuração realizada com sucesso!',
                    'redirect' => '/mode_operation.php?&session='.$session.'&ids='.$responseData['ids'][0],
                    'ids' => $responseData['ids'][0]
                );
               
            } else {
                
                $retorno = array(
                    'codigo' => 501,
                    'status' => false,
                    'hideDiv' => false,
                    'error' => $responseData
                );
            }
        
        }
    
    } 
    echo json_encode($retorno);


}

if(isset($_POST['action_form']) && $_POST['action_form'] == 'set_configurations'){
    
    setConfigurations($_REQUEST['server_id'], $_REQUEST['session']);
}

//metodo para criar referência do servidor no equipamento

function setConfigurations($serverId, $session) {

    if(empty($session)) {
        $retorno = array(
            'codigo' => 501,
            'status' => false,
            'mesagem' => 'Não há sessão ativa, é necessário realizar login para continuar',
            'error' => $responseData
        );
    } else {

        $data = array(
            "online_client" => array(
                "server_id" => $serverId,
            )
        );
        

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.168.1.7/set_configuration.fcgi?session=".$session,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        if($response === FALSE){
            $retorno = array(
               'codigo' => 500,
               'status' => false
            );
        } else {
            $responseData = json_decode($response, TRUE);
        
            if(empty($responseData)) {
                
                //ativação do modo online (Enterprise)
                $active_mode_online = activeOnlineMode($session);

                //sucesso ao ativar modo online
                if($active_mode_online['codigo'] == 200) {

                    $retorno = array(
                        'codigo' => 200,
                        'status' => true,
                        'hideDiv' => true,
                        'messagem' => 'Servidor configurado com sucesso'
                    );
                } else {

                    $retorno = array(
                        'codigo' => 501,
                        'status' => false,
                        'hideDiv' => false,
                        'messagem' => 'Falha ao ativar modo online'
                    );
                }
                
            } else {
                
                $retorno = array(
                    'codigo' => 501,
                    'status' => false,
                    'hideDiv' => false,
                    'error' => $responseData
                );
            }
        
        }
    
    } 
    echo json_encode($retorno);
}


//Ativar o modo online (Enterprise)
function activeOnlineMode($session) {

    if(empty($session)) {
        $retorno = array(
            'codigo' => 501,
            'status' => false,
            'hideDiv' => false,
            'mesagem' => 'Não há sessão ativa, é necessário realizar login para continuar',
            'error' => $responseData
        );
    } else {

        $data = array(
            "general" => array(
                "online" => "1",
            ),
            "online_client" => array(
                "extract_template" => "0",
                "max_request_attempts" => "1"
            )
        );
        

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.168.1.7/set_configuration.fcgi?session=".$session,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
    
        $response = curl_exec($curl);
        
        curl_close($curl);

        if($response === FALSE){
            $retorno = array(
               'codigo' => 500,
               'status' => false
            );
        } else {
            $responseData = json_decode($response, TRUE);
        
            if(empty($responseData)) {
    
                $retorno = array(
                    'codigo' => 200,
                    'status' => true,
                    'hideDiv' => false,
                    'messagem' => 'Modo Online ativado com sucesso.'
                );
               
            } else {
                
                $retorno = array(
                    'codigo' => 501,
                    'status' => false,
                    'hideDiv' => false,
                    'error' => $responseData
                );
            }
        
        }
    
    } 
    return $retorno;

}

//metodo para fazer logout
if(isset($_POST['action_form']) && $_POST['action_form'] == 'logout'){
    logout($_REQUEST['session']);
}


function logout($session) {

    if(empty($session)) {
        $retorno = array(
            'codigo' => 501,
            'status' => false,
            'hideDiv' => false,
            'mesagem' => 'Não há sessão ativa, é necessário realizar login para continuar',
            'error' => $responseData
        );
    } else {

        $curl = curl_init();
       
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://192.168.1.7/set_configuration.fcgi?session=".$session,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ));
          
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        if($response === FALSE){
            $retorno = array(
               'codigo' => 500,
               'status' => false
            );
        } else {
            $responseData = json_decode($response, TRUE);
        
            if(empty($responseData)) {
    
                $retorno = array(
                    'codigo' => 200,
                    'status' => true,
                    'hideDiv' => false,
                    'redirect' => '/index.php',
                    'messagem' => 'Logout realizado com sucesso'
                );
               
            } else {
                
                $retorno = array(
                    'codigo' => 501,
                    'status' => false,
                    'hideDiv' => false,
                    'error' => $responseData
                );
            }
        
        }

    }

    echo json_encode($retorno);
}
