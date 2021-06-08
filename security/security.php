<?php
    class APIKey{

        public function ApiKey($user, $keyId, $requestSalt, $requestTimeStamp, $requestToken) : bool{
            return false;
        }

        public function GenerateSaltApi($user, $keyId){
            return sha1($user . "salted");
        }

    }
?>