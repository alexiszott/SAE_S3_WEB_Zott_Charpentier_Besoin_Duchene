<?php

namespace iutnc\touiter\action;

class WriteTouite extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($this->http_method === "GET") {
            $html = <<< FIN
            <form method="post">
                <input type="text" name="touite" placeholder="Écrivez votre touite !">
                <button type="submit" name="envoyer">Envoyer</button>
            </form>
FIN;
        }
        else {

        }
    }
}