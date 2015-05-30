-- Contenu de la table `formation`

-- CLÉ ÉTRANGÈRE : 'prest_id'
-- VÉRIFIER QUE LA TABLE 'prestataire' CONTIENT DES VALEURS AVANT D'INSÉRER

INSERT INTO `formation` (`form_id`, `form_libelle`, `form_contenu`, `form_date_debut`, `form_date_fin`, `form_lieu`, `form_prerequis`, `form_cout_credit`, `prest_id`) VALUES
(1, 'BackOffice', 'Contenu de la première formation', '2015-04-14', '2015-04-20', 'Paris', 'Base PHP', 300, 1),
(2, 'Interface Web', 'Contenu de la deuxième formation', '2015-06-04', '2015-06-07', 'Cergy', 'Connaissance HTML et CSS', 325, 1),
(3, 'Bureautique', 'Contenu de la troisième formation', '2015-06-12', '2015-06-19', 'Monaco', 'Suite Office', 150, 1),
(4, 'Formation 4', 'Contenu de la quatrième formation', '2015-06-22', '2015-06-29', 'Bogota', 'Suite Office', 275, 2),
(5, 'C++', 'Contenu de la cinquième formation', '2015-07-13', '2015-07-16', 'New York', 'Base de la programmation', 850, 2),
(6, 'Algorythmie Avancée', 'Contenu de la sixième formation', '2015-07-27', '2015-08-05', 'Lyon', 'Base de l''Algorythmie', 400, 1);