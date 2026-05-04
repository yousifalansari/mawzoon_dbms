CREATE VIEW Order_Details_View AS
SELECT 
    o.Order_ID,
    o.Order_type,
    o.Order_time,
    o.Status AS Order_Status,
    c.First_name,
    c.Last_name,
    p.Payment_method,
    p.Amount_paid
FROM ORDERS o
JOIN PLACES pl ON o.Order_ID = pl.Order_ID
JOIN CUSTOMER c ON pl.Customer_ID = c.Customer_ID
LEFT JOIN PAYMENT p ON o.Order_ID = p.Order_ID;

CREATE VIEW Event_Menu_View AS
SELECT 
    e.Event_name,
    e.Event_date,
    m.Item_name,
    m.Category,
    m.Price
FROM EVENTS e
JOIN FEATURES f ON e.Event_ID = f.Event_ID
JOIN MENU_ITEM m ON f.Item_ID = m.Item_ID;

CREATE VIEW Inventory_Status_View AS
SELECT 
    Ingredient_name,
    Quantity_available,
    Reorder_level
FROM INVENTORY
WHERE Quantity_available <= Reorder_level;
