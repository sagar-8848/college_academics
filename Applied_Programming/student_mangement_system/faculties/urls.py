from django.urls import path

from . import views


urlpatterns = [
    path("", views.faculty_list, name="faculty_list"),
    path("add/", views.add_faculty, name="add_faculty"),
    path("edit/<int:faculty_id>/", views.edit_faculty, name="edit_faculty"),
    path("delete/<int:faculty_id>/", views.delete_faculty, name="delete_faculty"),
]