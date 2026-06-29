from django.urls import path

from . import views


urlpatterns = [
    path("", views.result_list, name="result_list"),
    path("add/", views.add_result, name="add_result"),
    path("edit/<int:result_id>/", views.edit_result, name="edit_result"),
    path("delete/<int:result_id>/", views.delete_result, name="delete_result"),
]