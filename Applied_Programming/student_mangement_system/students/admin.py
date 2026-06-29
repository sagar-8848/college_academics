from django.contrib import admin
from .models import Student



@admin.register(Student)
class StudentAdmin(admin.ModelAdmin):
	list_display = ("student_id", "roll_number", "full_name", "semester", "email", "created_at")
	search_fields = ("full_name", "roll_number", "email")