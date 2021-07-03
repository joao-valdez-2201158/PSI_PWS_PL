-- DEPARTURE 

select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, 
                departure.name as origin, arrival.name as destination,
                departure.localization as origin_localization, arrival.localization as destination_localization,
                stopovers.date_of_departure, stopovers.date_of_arrival,
                    stopovers.hour_of_departure, stopovers.hour_of_arrival
                from flights 
                left join airplanes on flights.id_airplane = airplanes.id_airplane
                inner join stopovers on flights.id_flight = stopovers.id_flight
                left join airports as departure on stopovers.id_departure = departure.id_airport
                left join airports as arrival on stopovers.id_destination = arrival.id_airport                
				where departure.localization like "%'.$flight.'%"
                and stopovers.date_of_departure >= "'.$date.'"
                and stopovers.date_of_departure <= "'.$date_return.'"

                and  (
                    
                    select ifnull( sum(passengers_quantity),0) from airplanesstopovers
                    where id_stopover = stopovers.id_stopover
                    
                    ) < airplanes.lotation;
                    
-- RETURN 

select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, 
                            departure.name as origin, arrival.name as destination,
                            departure.localization as origin_localization, arrival.localization as destination_localization,
                            stopovers.date_of_departure, stopovers.date_of_arrival,
                            stopovers.hour_of_departure, stopovers.hour_of_arrival
                            from flights 
                            left join airplanes on flights.id_airplane = airplanes.id_airplane
                            inner join stopovers on flights.id_flight = stopovers.id_flight
                            left join airports as departure on stopovers.id_departure = departure.id_airport
                            left join airports as arrival on stopovers.id_destination = arrival.id_airport                
                            where arrival.localization like "%'.$destiny.'%"
                            and stopovers.date_of_departure >= "'.$date.'"
                            and stopovers.date_of_departure <= "'.$date_return.'"

                            and  (
                    
                            select ifnull( sum(passengers_quantity),0) from airplanesstopovers
                            where id_stopover = stopovers.id_stopover
                            
                            ) < airplanes.lotation;