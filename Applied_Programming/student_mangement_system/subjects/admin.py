from django.contrib import admin
from .models import Subject



@admin.register(Subject)
class SubjectAdmin(admin.ModelAdmin):
	list_display = ("subject_id", "subject_code", "subject_name", "course", "faculty", "credit_hours")
	search_fields = ("subject_name", "subject_code", "course__course_name", "faculty__full_name")