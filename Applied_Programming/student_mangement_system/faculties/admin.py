from django.contrib import admin
from .models import Faculty



@admin.register(Faculty)
class FacultyAdmin(admin.ModelAdmin):
	list_display = ("faculty_id", "full_name", "department", "email", "phone")
	search_fields = ("full_name", "department", "email")