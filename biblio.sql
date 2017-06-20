-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 07 Juin 2015 à 13:30
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `biblio`
--
CREATE DATABASE IF NOT EXISTS `biblio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `biblio`;

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `datedeath` date DEFAULT NULL,
  `bio` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `authors`
--

INSERT INTO `authors` (`id`, `name`, `first_name`, `photo`, `datebirth`, `datedeath`, `bio`, `created_at`, `updated_at`) VALUES
(3, 'Tolkien', 'J.R.R.', './files/authors/a03.jpg', '1892-01-03', '1973-09-02', 'John Ronald Reuel Tolkien est un écrivain, poète, philologue et professeur d’université anglais, né le 3 janvier 1892 à Bloemfontein et mort le 2 septembre 1973 à Bournemouth. Il est principalement connu pour ses romans Le Hobbit et Le Seigneur des anneaux.', '2014-02-05 13:17:51', '2014-02-05 13:17:51'),
(4, 'Delaney', 'Joseph', './files/authors/a04.jpg', '1945-07-25', NULL, 'Né le 25 juillet 1945 à Preston en Angleterre, il a tout d''abord exercé la profession de professeur d''anglais spécialisé en littérature fantastique.Sa carrière d''écrivain a commencé avec le livre Mercer''s Whore sous le pseudonyme de J. K. Haderack. Spécialisé dans les romans de jeunesse, il a ensuite utilisé son véritable nom pour écrire le cycle The Wardstone Chronicles (littéralement « Les Chroniques de la pierre des Ward ») connu officieusement comme la série de l''Épouvanteur.\r\n\r\nIl vit en Angleterre avec sa famille dans le Lancashire, où il puise son inspiration pour son œuvre. Il a trois enfants et sept petits-fils.', '2014-02-05 13:17:51', '2014-02-05 13:17:51'),
(5, 'Rowling', 'J.K.', './files/authors/a05.jpg', '1965-07-31', NULL, 'Joanne Rowling, OBE1, LL.D. (hon.), née le 31 juillet 1965 dans l’agglomération de Yate, dans le Gloucestershire, en Angleterre, est une romancière britannique, connue sous le pseudonyme J. K. Rowling. Elle doit sa notoriété mondiale à la série Harry Potter, dont les tomes traduits en au moins 67 langues ont été vendus à plus de 450 millions d''exemplaires. Elle a également utilisé les pseudonymes de Kennilworthy Whisp, Newt Scamander (sous forme de private joke) et Robert Galbraith.\r\n\r\nJeune mère divorcée vivant d’allocations, elle a commencé à écrire Harry Potter à l''école des sorciers en 19904 et a dû attendre de longues années et l''aide d''un agent littéraire, Christopher Little, avant que son livre paraisse en 1997 chez Bloomsbury. Le succès planétaire des six tomes suivants ainsi que des hors-série lui ont permis d''acquérir une fortune estimée en 2008 par le Sunday Times à 560 millions de livres (environ 590 millions d’euros ou 825 millions de USD, fin 2008) ; et d''apporter sa contribution à de nombreuses associations caritatives luttant contre la maladie et les inégalités sociales. Elle devient ainsi une philanthrope reconnue en cofondant notamment le Children''s High Level Group.', '2014-06-11 08:58:51', '2014-06-11 08:58:51');

-- --------------------------------------------------------

--
-- Structure de la table `author_book`
--

CREATE TABLE IF NOT EXISTS `author_book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) NOT NULL,
  `book_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `author_book`
--

INSERT INTO `author_book` (`id`, `author_id`, `book_id`) VALUES
(1, 3, 3),
(2, 1, 1),
(3, 2, 2),
(4, 4, 2),
(6, 5, 6),
(7, 5, 7),
(8, 5, 8),
(9, 5, 9),
(10, 5, 10),
(11, 5, 11),
(12, 4, 12),
(13, 4, 13),
(14, 4, 14),
(15, 4, 15),
(16, 4, 17),
(17, 4, 17),
(18, 4, 18),
(19, 4, 19),
(20, 4, 20),
(21, 3, 21),
(22, 3, 22),
(23, 3, 23),
(24, 3, 24),
(25, 3, 25),
(28, 1, 26),
(31, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `front_cover` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `npages` int(10) DEFAULT NULL,
  `datepub` date DEFAULT NULL,
  `language_id` int(10) NOT NULL,
  `genre_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `editor_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `books`
--

INSERT INTO `books` (`id`, `title`, `front_cover`, `summary`, `isbn`, `npages`, `datepub`, `language_id`, `genre_id`, `location_id`, `editor_id`, `created_at`, `updated_at`) VALUES
(5, 'Harry Potter à l''école des sorciers', './files/books/b01.jpg', 'Après la mort tragique de Lily et James Potter, Harry est recueilli par sa tante Pétunia, (la sœur de Lily) et son oncle Vernon. Ces derniers, possédant une haine féroce envers les parents d''Harry, le maltraitent et laissent leur fils Dudley l''humilier. Harry ne sait rien sur ses parents. On lui a toujours dit qu’ils étaient morts dans un accident de voiture.Le jour de ses 11 ans, un demi-géant du nom de Rubeus Hagrid vient le chercher pour l’emmener à Poudlard, une école de sorcellerie, où il est attendu pour la rentrée. Hagrid lui révèle qu’il est un sorcier comme ses parents et que ses parents ont en réalité été tués par l''un des plus grands mages noirs du monde de la sorcellerie, Voldemort, surnommé ', '2-07-054127-4', 240, '1998-11-16', 2, 7, 3, 1, '2014-06-11 08:41:36', '2014-06-11 08:41:36'),
(6, 'Harry Potter et la Chambre des secrets', './files/books/b02.jpg', 'Harry Potter passe l''été chez les Dursley.\r\n\r\nLe jour de son 12e anniversaire, son oncle Vernon reçoit Mr Mason (un riche promoteur immobilier) et sa femme, avec qui il espère faire des affaires. Pendant leur visite, les Dursley ordonnent à Harry de rester dans sa chambre et de ne pas se faire remarquer.\r\n\r\nMais pendant que les Mason et les Dursley discutent dans le salon, à l''étage Harry reçoit la visite de Dobby, un elfe de maison. Celui-ci met en garde le jeune sorcier et lui conseille de ne pas retourner à Poudlard, car un dangereux complot s''y préparerait. Mais Harry choisi d''ignorer cet avertissement, bien décidé à retourner à l''école.', '2-07-054129-0', 288, '1999-03-23', 1, 7, 3, 1, '2014-06-11 08:41:36', '2014-06-11 08:41:36'),
(7, 'Harry Potter et le Prisonnier d''Azkaban', './files/books/b03.jpg', 'Le monde des gens ordinaires, les Moldus, comme celui des sorciers, est en émoi : Sirius Black, un dangereux criminel, s''est échappé de la forteresse d''Azkaban. Les redoutables gardiens de la prison assureront la sécurité du collège Poudlard, car le prisonnier évadé recherche Harry Potter. C''est donc sous bonne garde que le jeune sorcier fait sa troisième rentrée. Mais est-il vraiment à l''abri du danger qui le menace ?', '2-07-054130-4', 360, '1999-10-19', 1, 7, 3, 1, '2014-06-11 08:49:11', '2014-06-11 08:49:11'),
(8, 'Harry Potter et la Coupe de Feu', './files/books/b04.jpg', 'Après un horrible été chez les Dursley, Harry Potter entre en quatrième année au collège de Poudlard. À quatorze ans, il voudrait simplement être un jeune sorcier comme les autres, retrouver ses amis Ron et Hermione, assister avec eux à la Coupe du Monde de quidditch, apprendre de nouveaux sortilèges et essayer des potions inconnues. Une grande nouvelle l''attend à son arrivée : la tenue à Poudlard d''un tournoi de magie entre les plus célèbres écoles de sorcellerie. Déjà les spectaculaires délégations étrangères font leur entrée… Harry se réjouit. Trop vite. Il va se trouver plongé au cœur des événements les plus dramatiques qu''il ait jamais eu à affronter. ', '2-07-054358-7', 656, '2000-10-29', 1, 7, 3, 1, '2014-06-11 08:49:11', '2014-06-11 08:49:11'),
(9, 'Harry Potter et l''Ordre du Phénix', './files/books/b05.jpg', 'À quinze ans, Harry s''apprête à entrer en cinquième année à Poudlard. Et s''il est heureux de retrouver le monde des sorciers, il n''a jamais été aussi anxieux. L''adolescence, la perspective des examens importants en fin d''année et ces étranges cauchemars... Car Celui-Dont-On-Ne-Doit-Pas-Prononcer-Le-Nom est de retour et, plus que jamais, Harry sent peser sur lui une terrible menace. Une menace que le ministère de la Magie ne semble pas prendre au sérieux, contrairement à Dumbledore. Poudlard devient alors le terrain d''une véritable lutte de pouvoir. La résistance s''organise autour de Harry qui va devoir compter sur le courage et la fidélité de ses amis de toujours...', '2-07-055685-9', 984, '2003-12-03', 1, 7, 3, 1, '2014-06-11 08:52:59', '2014-06-11 08:52:59'),
(10, 'Harry Potter et le Prince de sang-mêlé', './files/books/b06.jpg', 'Dans un monde de plus en plus inquiétant, Harry se prépare à retrouver Ron et Hermione. Bientôt, ce sera la rentrée à Poudlard, avec les autres étudiants de sixième année. Mais pourquoi le professeur Dumbledore vient-il en personne chercher Harry chez les Dursley ?', '2-07-057267-6', 720, '2005-10-01', 1, 7, 3, 1, '2014-06-11 08:52:59', '2014-06-11 08:52:59'),
(11, 'Harry Potter et les Reliques de la Mort', './files/books/b07.jpg', 'Dans cette ultime aventure, Harry doit accomplir la tâche que lui a confié Dumbledore : détruire les derniers Horcruxes afin de vaincre Voldemort. Pour cela, il sera accompagné de ses deux fidèles amis Ron et Hermione mais de nombreux obstacles les attendent...', '978-2070615360', 809, '2007-10-26', 1, 7, 3, 1, '2014-06-11 08:55:09', '2014-06-11 08:55:09'),
(12, 'L''Apprenti épouvanteur', './files/books/b08.jpg', 'Tom est le septième fils d''un septième fils, il est donc désigné pour devenir Epouvanteur. Il entame son apprentissage au cours duquel il devra affronter toutes sortes de créatures, et déjouer plus d''un mauvais tour! Frissons garantis…', '978-2-298-00509-7', 276, '2005-03-10', 1, 7, 1, 3, '2014-06-11 09:14:12', '2014-06-11 09:14:12'),
(13, 'La Malédiction de l''épouvanteur', './files/books/b09.jpg', 'L’Épouvanteur et son apprenti, Tom Ward, se rendent à Priestown pour y achever un travail. Dans les profondeurs des catacombes de la cathédrale est tapie une créature que l’Épouvanteur n’a jamais réussi à vaincre, une créature si mauvaise et si puissante qu’elle menace tout le comté. On l’appelle « le Fléau ». Tandis que le maître et son apprenti se préparent à mener la bataille de leur vie, ils s’aperçoivent que le Fléau n’est pas leur seul ennemi. L’Inquisiteur est arrivé… Il arpente le pays à la recherche de tous ceux qui combattent les forces de la nuit, qu’ils soient sorcières, sorciers ou épouvanteurs ! Tom et M. Grégory ne sont pas au bout de leurs peines… ', '78-2-298-00510-3', 300, '2006-06-15', 1, 7, 1, 3, '2014-06-11 09:14:12', '2014-06-11 09:14:12'),
(14, 'Le Secret de l''épouvanteur', './files/books/b10.jpg', 'Ce troisième tome des aventures fantastiques de Tom, l’apprenti Épouvanteur, est riche en émotion et en rebondissements. Un ancien apprenti le menace de tourmenter l’esprit de son père décédé s’il ne vole pas un grimoire permettant de faire apparaître le dieu qui fera régner un hiver sans fin. Une bien mauvaise posture dont Tom va devoir se sortir.', '978-2-7470-2573-7', 0, '2007-03-15', 1, 7, 1, 3, '2014-06-11 09:20:26', '2014-06-11 09:20:26'),
(15, 'Le Combat de l''épouvanteur', './files/books/b11.jpg', 'John Gregory, l’Épouvanteur, a décidé de mettre un terme aux agissements des malfaisantes sorcières de la colline de Pendle.\r\nLe plus inquiétant, c’est que les trois clans – les Deane, les Malkin et les Mouldheel – qui, jusqu’alors, étaient ennemis et se querellaient sans cesse – semblent vouloir faire alliance. Ainsi unis, leur puissance en sera considérablement augmentée. Les sorcières seraient même capables d’invoquer le Diable en personne !\r\nTom et son maître doivent donc se rendre là-bas pour éviter le pire.', '978-2-7470-2573-7', 406, '2008-03-13', 1, 7, 1, 3, '2014-06-11 09:20:26', '2014-06-11 09:20:26'),
(16, 'L''Erreur de l''épouvanteur', './files/books/b12.jpg', 'Attention ! Histoire à ne pas lire la nuit... ', '978-2-7470-2797-7', 0, '2009-01-15', 1, 7, 1, 3, '2014-06-11 09:26:17', '2014-06-11 09:26:17'),
(17, 'Le Sacrifice de l''épouvanteur', './files/books/b13.jpg', 'Attention ! Histoire à ne pas lire la nuit...', '978-2-7470-2798-4', 0, '2010-01-21', 1, 7, 1, 3, '2014-06-11 09:26:17', '2014-06-11 09:26:17'),
(18, 'Le Cauchemar de l''épouvanteur', './files/books/b14.jpg', 'La guerre. qui faisait rage au sud du Comté, a maintenant gagné l''ensemble du pays. A leur retour de Grèce. Tom Ward et John Gregory découvrent que les soldats ont mis le feu à la maison de Chipenden, réduisant en cendres la précieuse bibliothèque. De plus, pendant leur absence, les sorcières de Pendle ont libéré Lizzie l''Osseuse, que l''Epouvanteur avait enfermée dans une fosse. Rester dans le Comté s''avère trop dangereux. En compagnie de la jeune Alice, et des trois chiens, Griffe, Sang et Os, Tom et son maître s''embarquent pour l''île de Mona, gouvernée par le cruel lord Barrule. Seulement, ils n''y sont pas les bienvenus...\r\n', '978-2-7470-3457-9', 0, '2011-02-10', 1, 7, 1, 3, '2014-06-11 09:31:30', '2014-06-11 09:31:30'),
(19, 'Le Destin de l''épouvanteur', './files/books/b15.jpg', ' John Gregory, Tom Ward et son amie Alice, fuyant la guerre qui fait rage dans le Comté, accostent en Irlande. Là, ils vont affronter des mages particulièrement malfaisants, prêts à tout pour accroître leurs pouvoirs maléfiques et se débarrasser de l''Epouvanteur comme de son apprenti. Au cours d''une dangereuse mission, Tom se voit remettre la Lame du Destin, une épée venue de l''Autre Monde. Cette arme puissante lui permettra-t-elle de vaincre le Malin ? Mais s''il veut survivre, il doit encore s''entraîner... Et la seule personne capable de l''aider n''est autre que Grimalkin, la sorcière tueuse...', '978-2-7470-3701-3', 0, '2012-02-24', 1, 7, 1, 3, '2014-06-11 09:31:30', '2014-06-11 09:31:30'),
(20, 'Grimalkin et l''Épouvanteur', './files/books/b16.jpg', 'La sorcière Grimalkin a juré de tuer son ennemi personnel : le Malin ! Tandis que Tom, Alice et l’Épouvanteur retournent à Chipenden – John Gregory compte rebâtir sa maison, brûlée par les envahisseurs qui ont ravagé le Comté –, Grimalkin s’efforce de rejoindre la tour Malkin, pour y cacher la tête du Malin (que Tom a tranchée en Irlande). C’est dans cette tour que les soeurs de la mère de Tom, deux sorcières lamias, gardent de précieuses malles. Car ces dernières renferment des secrets qui permettraient à Tom de vaincre le Malin. Seulement, un groupe de sorcières, alliées du diable, pourchassent Grimalkin : elles veulent à tout prix récupérer la tête. Elles sont accompagnées d’un mage redoutable et d’une terrible créature mi-humain mi-loup, conçue par magie noire. Au cours d’un affrontement, le monstre hybride blesse Grimalkin. Si la sorcière en réchappe, elle reste néanmoins affaiblie par le poison distillé dans son sang… Tom Ward, son maître John Gregory, et Alice peuvent-ils encore compter sur elle ? ', '978-2-7470-4501-8', 0, '2013-01-24', 1, 7, 1, 3, '2014-06-11 09:33:57', '2014-06-11 09:33:57'),
(21, 'Bilbo le Hobbit', './files/books/b17.jpg', 'Bilbo, comme tous les hobbits, est un petit être paisible. L''aventure tombe sur lui comme la foudre quand le magicien Gandalf et treize nains barbus viennent lui parler de trésor, d''expédition périlleuse à la Montagne Solitaire gardée par le grand dragon Smaug, car Bilbo partira avec eux !', '2253049417', 320, '2007-06-18', 1, 7, 2, 4, '2014-06-11 09:50:38', '2014-06-11 09:50:38'),
(22, 'Le Silmarillion', './files/books/b18.jpg', 'Les Premiers jours du Monde étaient à peine passés quand Fëanor, le plus doué des elfes, créa les trois Silmarils. Ces bijoux renfermaient la Lumière des Deux Arbres de Valinor.\r\n\r\nMorgoth, le premier Prince de la Nuit, était encore sur la Terre du Milieu, et il fut fâché d''apprendre que la Lumière allait se perpétuer. Alors il enleva les Silmarils, les fit sertir dans son diadème et garder dans la forteresse d''Angband.\r\n\r\nLes elfes prirent les armes pour reprendre les joyaux et ce fut la première de toutes les guerres. Longtemps, longtemps après, lors de la Guerre de l''Anneau, Elrond et Galadriel en parlaient encore. ', '2266121022', 478, '2001-11-08', 1, 7, 2, 5, '2014-06-11 09:50:38', '2014-06-11 09:50:38'),
(23, 'Le Seigneur des Anneaux : La Communauté de l''Anneau', './files/books/b19.jpg', 'Aux temps reculés qu''évoque le récit, la Terre est peuplée d''innombrables créatures étranges. Les Hobbits, apparentés à l''homme, mais proches également des Elfes et des Nains, vivent en paix au nord-ouest de l''Ancien Monde, dans la Comté.\r\n\r\nPaix précaire et menacée, cependant, depuis que Bilbon Sacquet a dérobé au monstre Gollum l''anneau de Puissance jadis forgé par Sauron de Mordor. Car cet anneau est doté d''un pouvoir immense et maléfique. Il permet à son détenteur de se rendre invisible et lui confère une autorité sans limites sur les possesseurs des autres anneaux. Bref, il fait de lui le Maître du Monde. C''est pourquoi Sauron s''est juré de reconquérir l''anneau par tous les moyens. Déjà ses Cavaliers Noirs rôdent aux frontières de la Comté.', '2266162411', 0, '2006-01-31', 1, 7, 2, 5, '2014-06-11 09:57:03', '2014-06-11 09:57:03'),
(24, 'Le Seigneur des Anneaux : Les Deux Tours', './files/books/b20.jpg', 'Frodon le Hobbit et ses Compagnons se sont engagés, au Grand Conseil d''Elrond, à détruire l''Anneau de Puissance dont Sauron de Mordor cherche à s''emparer pour asservir tous les peuples de la terre habitée : Elfes et Nains, Hommes et Hobbits.\r\n\r\nDès les premières étapes de leur audacieuse entreprise, les Compagnons de Frodon vont affronter les forces du Seigneur des Ténèbres et bientôt ils devront se disperser pour survivre. Parviendront-ils à échapper aux Cavaliers de Rohan ? Trouveront-ils asile auprès de Ceux des Arbres, grâce à l''entremise de Sylvebarbe ? Qu''adviendra-t-il de Gandalf le Gris métamorphosé, au-delà de la mort, en Cavalier Blanc ?', '2266199803', 0, '2009-09-10', 1, 7, 2, 5, '2014-06-11 09:57:03', '2014-06-11 09:57:03'),
(25, 'Le Seigneur des Anneaux : Le Retour du Roi', './files/books/b21.jpg', 'Avec Le Retour du Roi s''achèvent dans un fracas d''apocalypse les derniers combats de la guerre de l''anneau.\r\n\r\nTandis que le continent se couvre de ténèbres annonçant pour le peuple des Hobbits l''aube d''une ère nouvelle, Frodon poursuit son entreprise. Alors qu''il n''a pu franchir la Porte Noire il se demande comment atteindre le Mont du Destin.\r\n\r\nPeut-être est-il trop tard : le Seigneur des Ténèbres mobilise ses troupes. Les Rohirrim n''ont plus le temps d''en finir avec le traître assiégé dans l''imprenable tour d''Orthanc ; ils doivent se rassembler pour faire face à l''ennemi.\r\n\r\nTentant une fois de plus sa chance, Frodon passe par le Haut Col, où il sera livré à l''abominable Arachné. Survivra-t-il à son dangereux périple à travers le Pays Noir ? ', '226616242X', 0, '2006-01-13', 1, 7, 2, 5, '2014-06-11 09:58:45', '2014-06-11 09:58:45');

-- --------------------------------------------------------

--
-- Structure de la table `editors`
--

CREATE TABLE IF NOT EXISTS `editors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `editors`
--

INSERT INTO `editors` (`id`, `name`, `website`, `logo`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Gallimard', 'http://www.gallimard.fr/', './files/publishers/p01.jpg', 'Les Éditions Gallimard, appelées jusqu’en 1919 les éditions de la Nouvelle Revue française et jusqu’en 1961 la librairie Gallimard, sont un groupe d''édition français. La maison d''édition a été fondée par Gaston Gallimard en 1911. Le groupe Gallimard est actuellement dirigé par Antoine Gallimard. Considérée comme l''une des plus importantes et influentes maisons d''édition en France, notamment pour la littérature du XXe siècle et contemporaine, Gallimard est le diffuseur, en 2011, d''un catalogue comprenant 36 prix Goncourt, 38 écrivains ayant reçu le prix Nobel de littérature, et 10 écrivains récompensés du prix Pulitzer. Gallimard fait partie du Groupe Madrigall, le troisième pôle éditorial français.', '2014-02-05 13:21:08', '2014-02-05 13:21:08'),
(2, 'J''ai Lu', 'http://www.jailu.com/', './files/publishers/p02.jpg', 'J''ai lu est une maison d''édition française à Paris créée en 1958 par Frédéric Ditis à la demande d''Henri Flammarion. Sa ligne éditoriale est très variée : romans de littérature générale, science-fiction, fantastique, fantasy, bande dessinée, manga (abandonné), roman policier, roman d''amour. Elle publie essentiellement en format poche, mais a aussi édité la collection Millénaires (53 titres, maintenant arrêtée) au format 130 x 200 et en grand format le cycle de La Tour sombre de Stephen King ainsi que la collection Nouveaux Millénaires initiée en 2011. Depuis 2004, elle fait partie du groupe Flammarion. En avril 2006, J''ai lu a cessé l''édition des titres Shūeisha.', '2014-02-05 13:21:08', '2014-02-05 13:21:08'),
(3, 'Bayard Jeunesse', 'http://www.bayard-jeunesse.com/', './files/publishers/p03.jpg', 'Bayard est un groupe de presse français créé en 1873, juste après la guerre franco-prussienne de 1870, par le père Emmanuel d''Alzon (1810/1880), fondateur de la congrégation religieuse catholique Les Augustins de l''Assomption. Cette congrégation est aujourd''hui encore la propriétaire exclusive du groupe. Le groupe présent dans 16 pays communique par la presse, l''édition, Internet et l''audiovisuel dans les domaines de l''actualité (La Croix, Le Pèlerin), la jeunesse (Pomme d''Api, Youpi, Babar, J''aime lire, Astrapi, Okapi, Phosphore, Je bouquine, Wapiti, Les clés de l''Actualité), les séniors (Notre temps), le religieux (Prions en Église, Croire, Panorama), la nature (Terre sauvage, Alpes Magazine, Pyrénées Magazine, Pays basque Magazine, Bretagne Magazine). La liste de ces journaux et revues n''est pas exhaustive. Bayard est au 5e rang des groupes de presse français par la diffusion de La Croix, Le Pèlerin (4e hebdomadaire d''actualité), Notre Temps (en tête des publications mensuelles avec 993 000 exemplaires indiqués par l''OJD pour 2010), Pomme d''Api, etc. Il est aussi le 4e éditeur d''hebdomadaires, de revues ou de livres pour la jeunesse.', '2014-06-11 09:06:13', '2014-06-11 09:06:13'),
(4, 'Livre de Poche', 'http://www.livredepoche.com/', './files/publishers/p04.jpg', 'Le Livre de poche (parfois abrégé LDP) est, à l''origine, le nom d''une collection littéraire apparue le 9 février 1953 sous l''impulsion d''Henri Filipacchi et éditée par la Librairie générale française, filiale d''Hachette depuis 1954.', '2014-06-11 09:44:46', '2014-06-11 09:44:46'),
(5, 'Pocket', 'http://www.pocket.fr/livres-poche/', './files/publishers/p05.jpg', 'Créé à l''origine par les Presses de la Cité en 1962 sous le nom de Presses Pocket, Pocket est un éditeur généraliste de littérature au format poche dont les collections couvrent tous les genres de la fiction et de la non-fiction. Éditeur généraliste, Pocket publie de nombreux best-sellers en littérature, en thrillers ou encore en policiers.', '2014-06-11 09:48:59', '2014-06-11 09:48:59');

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Polar', NULL, '2014-02-05 11:03:05', '2014-02-05 11:03:05'),
(2, 'Essai', NULL, '2014-02-05 11:03:05', '2014-02-05 11:03:05'),
(3, 'Biographie', NULL, '2014-02-05 11:06:00', '2014-02-05 11:06:00'),
(4, 'Historique', NULL, '2014-02-05 11:06:00', '2014-02-05 11:06:00'),
(5, 'Social', NULL, '2014-02-05 11:06:33', '2014-02-05 11:06:33'),
(6, 'Aventure', NULL, '2014-02-05 11:06:33', '2014-02-05 11:06:33'),
(7, 'Fantasy', NULL, '2014-06-11 08:37:05', '2014-06-11 08:37:05');

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `languages`
--

INSERT INTO `languages` (`id`, `code`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'fr', 'Français', '2014-02-05 13:05:09', '2014-02-05 13:05:09'),
(2, 'en', 'Anglais', '2014-02-05 13:05:09', '2014-02-05 13:05:09'),
(3, 'de', 'Allemand', '2014-02-05 13:05:31', '2014-02-05 13:05:31'),
(4, 'nl', 'Néerlandais', '2014-02-05 13:05:31', '2014-02-05 13:05:31');

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `locations`
--

INSERT INTO `locations` (`id`, `code`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'rayon1', 'Rayon 1', NULL, '2014-02-05 13:09:04', '2014-02-05 13:09:04'),
(2, 'rayon2', 'Rayon 2', NULL, '2014-02-05 13:09:04', '2014-02-05 13:09:04'),
(3, 'rayon3', 'Rayon 3', NULL, '2014-02-05 13:09:33', '2014-02-05 13:09:33'),
(4, 'rayon4', 'Rayon 4', NULL, '2014-02-05 13:09:33', '2014-02-05 13:09:33'),
(5, 'rayon5', 'Rayon 5', NULL, '2014-02-05 13:09:45', '2014-02-05 13:09:45');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'examen@hepl.be', 'ae0de9e32bf65dbd1d0dfc725b620c91c6ba2912', '2014-06-11 08:27:25', '2014-06-11 08:27:25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
