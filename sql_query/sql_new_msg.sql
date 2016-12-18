SELECT 
u.id, u.Surname, u.Name, u.middleName, u.avatar, 
m.status, m.from_whom, m.whom, m.date_time, m.msg, m.id
FROM users u
INNER JOIN msg m ON (m.from_whom = u.id)
WHERE NOT (m.status = 1)
ORDER BY m.id DESC
/* ********************************** */
SELECT 
u.Surname, u.Name, u.middleName, u.id, u.avatar,
m.status, m.from_whom, m.whom, m.date_time, m.msg, m.id as ids
FROM users u
INNER JOIN msg m ON  (m.from_whom = u.id OR m.whom = u.id) AND NOT u.id = 3
WHERE m.from_whom = 3 OR m.whom = 3
ORDER BY m.date_time DESC
/* ********************************** */
SELECT 
u.Surname, u.Name, u.middleName, u.id, u.avatar,
m.status, m.from_whom, m.whom, m.date_time, m.msg
FROM users u
INNER JOIN msg m ON (m.from_whom = u.id OR m.whom = u.id) AND NOT u.id = 3
WHERE m.whom = 3 AND m.status = 0
ORDER BY m.date_time DESC