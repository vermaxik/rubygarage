1. get all statuses, not repeating, alphabetically ordered
mysql> SELECT status FROM tasks GROUP by status ASC;

2. get the count of all tasks in each project, order by tasks count descending
mysql> SELECT count(*) as count, project_id FROM tasks  GROUP by project_id ORDER by count DESC;

3. get the count of all tasks in each project, order by projects names
mysql> SELECT count(*) as count, p.project_name FROM tasks t INNER JOIN project p ON (p.project_id=t.project_id) GROUP by t.project_id ORDER by p.project_name asc;

4. get the tasks for all projects having the name beginning with “N” letter
mysql> SELECT t.task_name, p.project_name FROM tasks t INNER JOIN project p ON (p.project_id=t.project_id) WHERE p.project_name LIKE 'S%';

5. get the list of all projects containing the ‘a’ letter in the middle of the name, and show the tasks count near each project. Mention that there can exist projects without tasks and tasks with project_id=NULL
mysql> SELECT p.project_name, (SELECT count(*) FROM tasks t WHERE t.project_id=p.project_id) as count FROM project p  WHERE p.project_name LIKE '%a%';

6. get the list of tasks with duplicate names. Order alphabetically
mysql> SELECT * FROM tasks WHERE task_name IN (SELECT task_name FROM tasks GROUP BY task_name HAVING COUNT(task_name)>1) ORDER by task_name ASC;

7. get the list of tasks having several exact matches of both name and status, from the
project ‘Garage’. Order by matches count

mysql> SELECT t.* FROM tasks t INNER JOIN project p ON (t.project_id=p.project_id) WHERE p.project_name='Garage' and (t.task_name,t.status) IN (SELECT task_name,status FROM tasks GROUP BY task_name,status HAVING COUNT(*)>1) ORDER by t.task_name ASC, t.status ASC;

8. get the list of project names having more than 10 tasks in status ‘completed’. Order by project_id

mysql> SELECT project_name,project_id FROM project WHERE project_id IN (SELECT  if(count(*)>'10',project_id,0) FROM tasks WHERE status='1' GROUP by project_id) ORDER by project_id ASC;