<?php
class SuspendedAdherentXML {
    const XML_FILE = __DIR__ . '/../suspended_adherents.xml';

    public static function add($adherent, $emprunts) {
        try {
            // Charger ou créer le XML (si vide ou corrompu, on repart de zéro)
            $xml = null;
            if (file_exists(self::XML_FILE) && filesize(self::XML_FILE) > 0) {
                libxml_use_internal_errors(true);
                $xml = simplexml_load_file(self::XML_FILE);
                if ($xml === false) {
                    // Fichier corrompu, on le réinitialise
                    $xml = new SimpleXMLElement('<suspendedAdherents></suspendedAdherents>');
                }
                libxml_clear_errors();
            } else {
                $xml = new SimpleXMLElement('<suspendedAdherents></suspendedAdherents>');
            }

            // Supprimer l'adhérent s'il existe déjà (pour éviter les doublons)
            self::remove($adherent->id_adh, $xml);

            // Ajouter l'adhérent suspendu
            $adh = $xml->addChild('adherent');
            $adh->addChild('id', $adherent->id_adh);
            $adh->addChild('nom', $adherent->nom);
            $adh->addChild('adresse', $adherent->adresse);
            $empruntsNode = $adh->addChild('emprunts');
            foreach ($emprunts as $emp) {
                $empNode = $empruntsNode->addChild('emprunt');
                $empNode->addChild('idEmp', $emp->id_emp);
                $livresNode = $empNode->addChild('livres');
                if (!empty($emp->livres)) {
                    foreach ($emp->livres as $livre) {
                        $livreNode = $livresNode->addChild('livre');
                        $livreNode->addChild('refLivre', $livre->ref_livre ?? '');
                        $livreNode->addChild('titre', $livre->titre ?? '');
                    }
                }
            }
            // Sauvegarder le XML
            $xml->asXML(self::XML_FILE);
        } catch (Exception $e) {
            if (function_exists('set_error')) {
                set_error('danger', "Erreur XML (add) : " . $e->getMessage(), $e);
            }
        }
    }

    /**
     * Supprime un adhérent suspendu du XML.
     * @param int $id_adh
     * @param SimpleXMLElement|null $xml (optionnel, pour usage interne)
     */
    public static function remove($id_adh, $xml = null) {
        try {
            if ($xml === null) {
                if (!file_exists(self::XML_FILE) || filesize(self::XML_FILE) === 0) return;
                libxml_use_internal_errors(true);
                $xml = simplexml_load_file(self::XML_FILE);
                if ($xml === false) {
                    // Fichier corrompu, on le réinitialise
                    $xml = new SimpleXMLElement('<suspendedAdherents></suspendedAdherents>');
                }
                libxml_clear_errors();
            }
            $found = false;
            if (isset($xml->adherent)) {
                $count = is_countable($xml->adherent) ? count($xml->adherent) : 0;
                for ($i = 0; $i < $count; $i++) {
                    if ((string)$xml->adherent[$i]->id === (string)$id_adh) {
                        unset($xml->adherent[$i]);
                        $found = true;
                        break;
                    }
                }
            }
            // Sauvegarder le XML si modifié ou si appelé directement
            if ($found || func_num_args() == 1) {
                $xml->asXML(self::XML_FILE);
            }
        } catch (Exception $e) {
            if (function_exists('set_error')) {
                set_error('danger', "Erreur XML (remove) : " . $e->getMessage(), $e);
            }
        }
    }
}
