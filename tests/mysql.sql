DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NULL,
  `name` varchar(255) NULL,
  `parentId` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `path` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Category` (`id`, `class`, `name`, `parentId`, `path`)
VALUES
  (1, 'Harp\\MP\\Test\\Category', 'Root', 0, null),
  (2, 'Harp\\MP\\Test\\Category', 'Category 1', 1, '1'),
  (3, 'Harp\\MP\\Test\\Category', 'Category 2', 1, '1'),
  (4, 'Harp\\MP\\Test\\Category', 'Sub Category 1', 2, '1/2'),
  (5, 'Harp\\MP\\Test\\Category', 'Sub Category 2', 2, '1/2'),
  (6, 'Harp\\MP\\Test\\Category', 'Sub Category 3', 3, '1/3'),
  (7, 'Harp\\MP\\Test\\Subcategory', 'Leaf 1', 6, '1/3/6'),
  (8, 'Harp\\MP\\Test\\Subcategory', 'Leaf 2', 6, '1/3/6');
