insert into defaultvalues (`code`, `name`, `value`, `type`, `valid`, `date`, `ip`)
values ('numseries', 'Last number in series for numbering packages', '0', 'company', '1', '2018-07-23', '');

insert into defaultvalues (`code`, `name`, `value`, `type`, `valid`, `date`, `ip`)
values ('numseriesmonth', 'Current month in series for numbering packages', '0718', 'company', '1', '2018-07-23', '');

grant execute on function mve0.get_next_in_number_series to 'orgmveapp'@'%';