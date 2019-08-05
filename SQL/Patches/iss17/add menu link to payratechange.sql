-- push Help menu item further down
UPDATE hd_menu1
SET kol = 15
WHERE lp = 78;

INSERT INTO hd_menu1 (mnu_nazwa, mnu_nr, mnu_plik, kol)
VALUES ('Payrate change', 8, 'payratechange.php', 11);