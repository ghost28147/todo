```sql
    create database todo;
    
    use todo;
    
    create table item
    (
    	id int auto_increment primary key,
    	content varchar(255) not null,
    	created_at timestamp default CURRENT_TIMESTAMP not null,
    	done tinyint(1) default '0' not null
    );
```
