
CREATE TABLE `staff_rank` (
  `id` int(11) NOT NULL,
  `rank` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `staff_rank`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT; 


CREATE TABLE `staff_unit` (
  `id` int(11) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `staff_unit`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT; 

CREATE TABLE `staff_wing` (
  `id` int(11) NOT NULL,
  `wing` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `staff_wing`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_wing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `staff_disease` (
  `id` int(11) NOT NULL,
  `disease` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `staff_disease`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_disease`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT; 
 



ALTER TABLE `patients`
  ADD `designation` varchar(255) NULL;

ALTER TABLE `patients`
  ADD `wing` varchar(255) NULL;