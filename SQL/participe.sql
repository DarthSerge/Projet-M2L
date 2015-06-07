-- Contenu de la table `participe`

-- CLÉ ÉTRANGÈRE : 'form_id' et 'user_id'
-- VÉRIFIER QUE LES TABLES 'formation' et 'user' CONTIENNENT DES VALEURS AVANT D'INSÉRER

INSERT INTO `participe` (`form_id`, `user_id`, `part_statut`) VALUES
(1, 2, 'terminee');