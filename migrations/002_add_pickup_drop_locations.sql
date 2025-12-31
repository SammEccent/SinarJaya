-- Add pickup and drop point columns to bookings table
ALTER TABLE `bookings` 
ADD COLUMN `pickup_location_id` INT NULL AFTER `schedule_id`,
ADD COLUMN `drop_location_id` INT NULL AFTER `pickup_location_id`,
ADD CONSTRAINT `fk_booking_pickup` FOREIGN KEY (`pickup_location_id`) REFERENCES `location` (`location_id`),
ADD CONSTRAINT `fk_booking_drop` FOREIGN KEY (`drop_location_id`) REFERENCES `location` (`location_id`);

-- Add indexes for better performance
ALTER TABLE `bookings`
ADD INDEX `idx_pickup_location` (`pickup_location_id`),
ADD INDEX `idx_drop_location` (`drop_location_id`);
