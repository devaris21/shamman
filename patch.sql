ALTER TABLE `ligneapprovisionnement` CHANGE `quantite` `quantite` FLOAT(11) NOT NULL, CHANGE `quantite_recu` `quantite_recu` FLOAT(11) NOT NULL;

ALTER TABLE `approvisionnement` ADD `avance` INT NOT NULL AFTER `montant`, ADD `reste` INT NOT NULL AFTER `avance`;

UPDATE approvisionnement set avance = montant;