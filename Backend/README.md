# This is a temporary doc for backend API
## POST method
### http://localhost/its/student_register
- Can be use for student account only, will immediately create active student account
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
    - 400 or 500: error
### http://localhost/its/teacher_register
- Can be use for teacher account only, will immediately create inactive teacher account. Need admin to activate teacher account
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
    - 400 or 500: error
### http://localhost/its/user_login
- Can be use for any
- Input:
    - Email:  string, valid email format
    - Password: string, 8-100 characters, at least 1 uppercase, lowercase, @$!%*?& and 0-9 number
- Output:
    - 200: successfully registered
        - Include JWT token
    - 400 or 500: error
