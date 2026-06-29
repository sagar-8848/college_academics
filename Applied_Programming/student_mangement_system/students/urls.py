from django.urls import path
from .views import dashboard, student_list, add_student, edit_student, delete_student


urlpatterns = [
    # * Dashboard
    path("", dashboard, name="dashboard"),

    # * Student List
     path(
        'students/',
        student_list,
        name='student_list'
    ),

    # * Add Student
    path(
        'students/add/',
        add_student,
        name='add_student'
    ),

    # * Edit Student
    path(
        'students/edit/<int:student_id>/',
        edit_student,
        name='edit_student'
    ),

    # * delete student
    path(
    "students/delete/<int:student_id>/",
    delete_student,
    name="delete_student"
),

]