from django.urls import path

from . import views


urlpatterns = [
    path("", views.enrollment_list, name="enrollment_list"),
    path("add/", views.add_enrollment, name="add_enrollment"),
    path("edit/<int:enrollment_id>/", views.edit_enrollment, name="edit_enrollment"),
    path("delete/<int:enrollment_id>/", views.delete_enrollment, name="delete_enrollment"),
]