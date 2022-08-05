## Start work

```sh
$ git clone https://github.com/KutsenkoIhor/UniqueTravelTime.git
```

- #### In the main.php file, specify the file names for reading and saving.
- PATH_FILE_READ = "trips.csv";
- PATH_FILE_WRITE = "report.csv";
```sh
$ php main.php
```

## Task

```sh
Файл trips.csv містить дані поїздок пасажирів: 
- 'id'        : ID поїздки одного пасажира         
- 'driver_id' : ID водія
- 'pickup'    : дата і час посадки пасажира  
- 'dropoff'   : дата і час висадки пасажира

Завдання: написати PHP код, який читає файл і генерирує звіт по всіх водіях, як CSV файл з наступними колонками:  
- 'driver_id'                    : ID водія
- 'total_minutes_with_passenger' : загальний час, протягом якого водій їхав хоча би з одним пасажиром в автомобілі

Враховуючи, що в одному автомобілі можуть одночасно їхати кілька пасажирів.

Оцінюється:
- Правильність алгоритму
- Ефективність алгоритму
- Якість коду 
```