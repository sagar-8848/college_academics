from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ("results", "0001_initial"),
        ("subjects", "0002_subject_subject_code_subject_faculty"),
    ]

    operations = [
        migrations.AddField(
            model_name="result",
            name="subject",
            field=models.ForeignKey(
                blank=True,
                db_column="subject_id",
                null=True,
                on_delete=django.db.models.deletion.CASCADE,
                to="subjects.subject",
            ),
        ),
        migrations.AlterUniqueTogether(
            name="result",
            unique_together={("student", "exam", "subject")},
        ),
    ]