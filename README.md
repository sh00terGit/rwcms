-- генерация сеттеров и геттеров
php app/console doctrine:generate:entities Nod4/RpsAdminBundle/Entity/MenuType

-- маппинг в базу 
php app/console doctrine:schema:update --force

--- импорт в хмл базы
 php app/console doctrine:mapping:import --force RpsAdminBundle xml


удаляем хмл ненужное

php app/console doctrine:mapping:convert annotation ./src

конвертируем импорт в объекты



-- генерация формы
php app/console generate:doctrine:form RpsAdminBundle: