DELIMITER $$

CREATE TRIGGER update_order_total
AFTER INSERT ON CONTAIN
FOR EACH ROW
BEGIN
  UPDATE ORDERS
  SET Total_amount = (
    SELECT SUM(Quantity * Unit_price)
    FROM CONTAIN
    WHERE Order_ID = NEW.Order_ID
  )
  WHERE Order_ID = NEW.Order_ID;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER reduce_inventory_after_order
AFTER INSERT ON CONTAIN
FOR EACH ROW
BEGIN
  UPDATE INVENTORY i
  JOIN ITEM_USES iu ON i.Inventory_ID = iu.Inventory_ID
  SET i.Quantity_available = i.Quantity_available - (iu.Quantity_used * NEW.Quantity)
  WHERE iu.Item_ID = NEW.Item_ID;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER restore_inventory_after_delete
AFTER DELETE ON CONTAIN
FOR EACH ROW
BEGIN
  UPDATE INVENTORY i
  JOIN ITEM_USES iu ON i.Inventory_ID = iu.Inventory_ID
  SET i.Quantity_available = i.Quantity_available + (iu.Quantity_used * OLD.Quantity)
  WHERE iu.Item_ID = OLD.Item_ID;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER update_order_status_after_payment
AFTER INSERT ON PAYMENT
FOR EACH ROW
BEGIN
  UPDATE ORDERS
  SET Status = 'Paid'
  WHERE Order_ID = NEW.Order_ID;
END $$

DELIMITER ;