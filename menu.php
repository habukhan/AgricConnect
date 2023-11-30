<?php
include_once 'util.php';

class Menu {
    protected $text;
    protected $sessionId;
    
    function __construct(){}

    public function mainMenuRegistered(){
        $response = "CON Reply  with\n";
        $response .= "1. Send  Money\n";
        $response .= "2. Withdraw\n";
        $response .= "3. Check Balance\n";
        echo $response;
    }

    public function mainMenuUnRegistered(){
        $response = "CON Wellcome!. Reply with\n";
        $response .= "1. Open Account\n";
        echo $response;
    }
  
    public function registerMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Please enter your full name:";
        } else if($level == 2){
            echo "CON Please set your PIN:";
        } else if($level == 3){
            echo "CON Please confirm your PIN:";
        } else if($level == 4){
            $name = $textArray[1];
            $pin = $textArray[2];
            $confirmPin = $textArray[3];
            if($pin != $confirmPin){
                echo "END Your pins do not match. Please try again";
            } else {
                //we can register the user
                //send sms
                echo "END You have been registered";
            }
        }
    }

    public function sendMoneyMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON  Enter mobile number of the receiver:";
        }else if($level ==2){
            echo "CON  Enter amount:";
        }else if($level ==3){
            echo "CON Enter your PIN:";
        }else if($level == 4){
            $response = "CON Send " . $textArray[2] . " to " . $textArray[2] . " \n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU . " Main menu\n"; 
            echo $response; 
        }else if($level == 5 && $textArray[4] == 1){
            //a confirm
            //send  the money plus process 
            //check if PIN correct
            //If you  have enough funds including charges etc.. 
            echo "END Your request is being processed";
        }else if($level == 5 && $textArray[4] == 2){
            //Cancel
            echo "END Thank you for using our service";
        }else if($level == 5 && $textArray[4] == Util::$GO_BACK){
            echo "END You have requested to back to one step - PIN";
        }else if($level == 5 && $textArray[4] == Util::$GO_TO_MAIN_MENU){
            echo "END You have requested to back to main menu"; 
        }else {
            echo "END Invalid Entry";
        }
    }

    public function withdrawMoneyMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter agent number:";
        }else if($level == 2){
            echo "CON Enter amount";
        }else if($level == 3){
            echo "CON Enter your PIN:";
        }else if($level == 4){
             echo "CON Withraw " . $textArray[2] . " from agent " . $textArray[1] . "\n 1. Confirm\n 2. Cancel\n";
        }else if($level == 5 && $textArray[4] == 1){
            //confirm
            echo "END Your request is being  processed";
        }else if($level == 5 && $textArray[4] == 2){
            //cancel
            echo "END Thank you";
        }else {
            echo "END Invalid entry";
        }
    }

    public function checkBalanceMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter PIN";
        }else if($level == 2){
            //logic
            //check PIN correctness etc..
            echo "END We are processing your request and you will receive an SMS shortly";
        }else {
            echo "END Invalid entry";
        }
    }

    public function middleware($text){
        //remove entries for going back and going to the main menu
         return $this->goBack($this->goToMainMenu($text));  
    }

    public function goBack($text){
          //1*4*5*1*98*2*1234*
          $explodedText = explode("*",$text);
        while(array_search(Util::$GO_BACK, $explodedText) != false){
            $firstIndex = array_search(Util::$GO_BACK, $explodedText);
            array_splice($explodedText, $firstIndex-1, 2);
        }
        return join("*",$explodedText); 
    }

    public function goToMainMenu($text){
        //1*4*5*99*2*1234*99
        $explodedText = explode("*",$text);
        while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
            $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
            $explodedText = array_slice($explodedText, $firstIndex + 1);
        }
        return join("*",$explodedText);  
    }


}

?>
