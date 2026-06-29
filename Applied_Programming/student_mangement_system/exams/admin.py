from django.contrib import admin
from .models import Exam



@admin.register(Exam)
class ExamAdmin(admin.ModelAdmin):
	list_display = ("exam_id", "subject", "exam_type", "exam_date", "total_marks")
	search_fields = ("exam_type", "subject__subject_name", "subject__subject_code")