from django.db import models
from subjects.models import Subject


class Exam(models.Model):
    exam_id = models.AutoField(primary_key=True)

    subject = models.ForeignKey(
        Subject,
        on_delete=models.CASCADE,
        db_column="subject_id"
    )

    exam_type = models.CharField(max_length=50)
    exam_date = models.DateField()
    total_marks = models.IntegerField()

    class Meta:
        db_table = "exams"

    def __str__(self):
        return f"{self.subject} - {self.exam_type}"