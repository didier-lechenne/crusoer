<?php

class PublicationPage extends Page {
    public function titrePrincipalTexte(): string {
        return strip_tags($this->titre_principal()->value());
    }
    public function titreSecondaireTexte(): string {
        return strip_tags($this->titre_secondaire()->value());
    }
}
