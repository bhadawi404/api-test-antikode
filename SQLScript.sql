
SELECT
	b.name as brand_name
FROM brands b ;



SELECT
	o.name AS outlet_name,
	o.address AS address,
	o.longitude AS longitude,
	o.latitude AS latitude
FROM outlets o;


SELECT
	sum(p.price) AS total_product
	FROM products p ;

SELECT o.name AS outlet_name,o.address AS outlet_address,o.latitude AS latitude ,o.longitude AS longitude, SQRT(
    POW(111.2 * (latitude - -6.17511506439825), 2)
    +
    POW(111.2 * (106.82746393252476 - longitude) * COS(latitude  / 57.3), 2)) AS distance
FROM outlets o HAVING distance <= 5 ORDER BY distance ASC;

