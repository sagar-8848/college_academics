from django.contrib import admin
from .models import Result



@admin.register(Result)
class ResultAdmin(admin.ModelAdmin):
	list_display = ("result_id", "student", "subject", "exam", "marks_obtained", "grade", "created_at")
	search_fields = ("student__full_name", "student__roll_number", "subject__subject_name", "grade")