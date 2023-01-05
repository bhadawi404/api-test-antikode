
select 
	b.name as brand_name 
from brands b ;



select 
	o.name as outlet_name,
	o.address as address,
	o.longitude as longitude,
	o.latitude as latitude 
from outlets o; 


select 
	sum(p.price) as total_product
	from products p ;
	
SELECT o.name as outlet_name,o.address as outlet_address,o.latitude as latitude ,o.longitude as longitude, SQRT(
    POW(111.2 * (latitude - -6.17511506439825), 2)
    +
    POW(111.2 * (106.82746393252476 - longitude) * COS(latitude  / 57.3), 2)) AS distance
FROM outlets o HAVING distance <= 5 ORDER BY distance ASC;

