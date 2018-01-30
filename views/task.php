<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
	<div class="container main-container">
		<div class="row">
			<div class="col">
				<form action="?/taskController/add" method="POST">
					<div class="input-group">
						<input type="hidden" name="id" value="{{ postTaskID }}">
						<input type="text" name="description" placeholder="описание задачи" value="{%if postEdit %} {{desc_change}} {% else %}{% endif %}" class="form-control">
						<div class="input-group-append">
							<input type="submit" name="save" value="{{button}}" class="btn btn-info">
						</div>
					</div>
				</form>				
			</div>
			<div class="col">
				<form action="index.php" method="POST">
					<div class="input-group">
						<select name="sort_by" class="custom-select">
							<option value="date_added">Дате добавления</option>
							<option value="is_done">Статусу</option>
							<option value="description">Описанию</option>
						</select>
						<div class="input-group-append">
							<input type="submit" name="sort" value="Отсортировать" class="btn btn-info">
						</div>
					</div>
				</form>	
			</div>
		</div>
		<div class="row">
			<h3 class="main-title">Здравствуйте, {{sessionName}}! Вот ваш список дел:</h3>
			<table class="table table-bordered table-sm table-top">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Описание задачи</th>
						<th scope="col">Дата добавления</th>
						<th scope="col">Статус</th>
						<th scope="col">Редактирование</th>
						<th scope="col">Исполнитель</th>
            			<th scope="col">Автор</th>
           				<th scope="col">Передать задачу другому</th>
					</tr>
				</thead>
				<tbody>
					{% for row in author %}
					{% if sessionId == row.user_id %}
					<tr>
						<td>{{row.description}}</td>
						<td>{{row.date_added}}</td>
						<td class="font-weight-bold">{% if row.is_done == 0 %}В процессе{% else %}Выполнено{% endif %}</td>
						<td>
							<form method="POST" action="?/taskController/redakt">
								<input type="hidden" name="task_id" value="{{row.task_id}}">
								<button class="badge badge-primary" type="submit" name="edit" value="Изменить">Изменить</button>
								{% if row.assigned_user_id == row.user_id %}
								<button class="badge badge-success" type="submit" name="done" value="Выполнить">Выполнить</button>
								{% endif %}
								<button class="badge badge-danger" type="submit" name="delete" value="Удалить">Удалить</button>
							</form>
						</td>
						<td>
							{% if row.assigned_user_name == row.login %}
							Вы
							{% else %}
							{{row.assigned_user_name}}
							{% endif %}
						</td>
						<td>{{row.login}}</td>
						<td>
							<form method="POST" action="?/taskController/changeAssigned">
								<div class="input-group">
									<input type="hidden" name="row_id" value="{{row.task_id}}">
									<select name='assigned_user_id' class="custom-select custom-select-sm">
										{% for user in users %}
										<option value="{{ user.id }}">{{ user.login }}</option>
										{% endfor %}
										<!-- <?php //foreach($this->model->findAllUsers() as $user) {
										//echo "<option value=" . $user['id'] . ">" . $user['login'] . "</option>";} ?>	 -->
									</select>
									<div class="input-group-append">
										<input type='submit' name='assign' class="btn btn-info btn-sm" value='Сменить исполнителя' />
									</div>
								</div>
							</form>
						</td>
					</tr>
					{% endif %}
					{% endfor %}
				</tbody>
			</table>
			<h3 class="main-title">Также, посмотрите, что от Вас требуют другие люди:</h3>
			<table class="table table-bordered table-sm table-bottom">
        		<thead class="thead-dark">
        			<tr>
	            		<th scope="col">Описание задачи</th>
	            		<th scope="col">Дата добавления</th>
	            		<th scope="col">Статус</th>
			            <th scope="col">Редактирование</th>
			            <th scope="col">Исполнитель</th>
			            <th scope="col">Автор</th>
		            </tr>
		        </thead>
				<tbody>
					{% for rows in responsible %}
					{% if rows.assigned_user_id == sessionId and sessionId != rows.user_id %}
					<tr>
						<td>{{ rows.description }}</td>
						<td>{{ rows.date_added }}</td>
						<td class="font-weight-bold">{% if rows.is_done==0 %}В процессе{% else %}Выполнено{% endif %}</td>
						<td>
							<form method="POST" action="?/taskController/redakt">
								<input type="hidden" name="task_id" value="{{ rows.id }}">
								<button class="badge badge-primary" type="submit" name="edit" value="Изменить">Изменить</button>
								<button class="badge badge-success" type="submit" name="done" value="Выполнить">Выполнить</button>
								<button class="badge badge-danger" type="submit" name="delete" value="Удалить">Удалить</button>
							</form>
						</td>
						<td>{{ rows.assigned_user_name }}</td>
						<td>{{ rows.login }}</td>
					</tr>
					{% endif %}
					{% endfor %}
				</tbody>
			</table>
			<a href="?/userController/logout" class="btn btn-secondary btn-lg">выйти</a>
	</div>
</body>
</html>

