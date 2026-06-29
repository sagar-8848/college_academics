from django.db import models
from students.models import Student
from subjects.models import Subject


class Enrollment(models.Model):
    enrollment_id = models.AutoField(primary_key=True)

    student = models.ForeignKey(
        Student,
        on_delete=models.CASCADE,
        db_column="student_id"
    )

    subject = models.ForeignKey(
        Subject,
        on_delete=models.CASCADE,
        db_column="subject_id"
    )

    enrollment_date = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "enrollments"
        unique_together = ("student", "subject")

    def __str__(self):
        return f"{self.student} enrolled in {self.subject}"