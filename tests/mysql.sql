DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NULL,
  `parentId` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `path` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Category` (`id`, `name`, `parentId`, `path`)
VALUES
  (1, 'Root', 0, null),
  (2, 'Category 1', 1, '1'),
  (3, 'Category 2', 1, '1'),
  (4, 'Sub Category 1', 2, '1/2'),
  (5, 'Sub Category 2', 2, '1/2'),
  (6, 'Sub Category 3', 3, '1/3'),
  (7, 'Leaf 1', 6, '1/3/6'),
  (8, 'Leaf 2', 6, '1/3/6');
