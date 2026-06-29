from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from .forms import EnrollmentForm
from .models import Enrollment
from django.contrib.auth.decorators import login_required
from django.contrib.auth.decorators import permission_required
from students.models import Student


@login_required
@permission_required("enrollments.view_enrollment")
def enrollment_list(request):

    search_query = request.GET.get("search", "")

    # -------------------------------
    # Student sees ONLY their enrollments
    # -------------------------------
    if request.user.groups.filter(name="Student").exists():

        student = get_object_or_404(
            Student,
            user=request.user
        )

        enrollments = Enrollment.objects.select_related(
            "student",
            "subject"
        ).filter(
            student=student
        )

    # -------------------------------
    # Admin / Faculty see everything
    # -------------------------------
    else:

        enrollments = Enrollment.objects.select_related(
            "student",
            "subject"
        ).all()

        if search_query:

            enrollments = enrollments.filter(
                Q(student__full_name__icontains=search_query)
                | Q(student__roll_number__icontains=search_query)
                | Q(subject__subject_name__icontains=search_query)
            ).distinct()

    paginator = Paginator(enrollments, 10)

    page_number = request.GET.get("page")

    page_obj = paginator.get_page(page_number)

    return render(
        request,
        "enrollments/enrollment_list.html",
        {
            "enrollments": page_obj,
            "page_obj": page_obj,
            "search_query": search_query,
        },
    )

@login_required
@permission_required("enrollments.add_enrollment")
def add_enrollment(request):
	form = EnrollmentForm(request.POST or None)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Enrollment added successfully!")
		return redirect("enrollment_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Add Enrollment",
			"submit_label": "Save Enrollment",
			"cancel_url": "/enrollments/",
		},
	)

@login_required
@permission_required("enrollments.change_enrollment")
def edit_enrollment(request, enrollment_id):
	enrollment = get_object_or_404(Enrollment, enrollment_id=enrollment_id)
	form = EnrollmentForm(request.POST or None, instance=enrollment)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Enrollment updated successfully!")
		return redirect("enrollment_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Edit Enrollment",
			"submit_label": "Update Enrollment",
			"cancel_url": "/enrollments/",
		},
	)

@login_required
@permission_required("enrollments.change_enrollment")
def delete_enrollment(request, enrollment_id):
	enrollment = get_object_or_404(Enrollment, enrollment_id=enrollment_id)

	if request.method == "POST":
		enrollment.delete()
		messages.success(request, "Enrollment deleted successfully!")
		return redirect("enrollment_list")

	return render(
		request,
		"shared/confirm_delete.html",
		{
			"title": "Delete Enrollment",
			"message": f"Are you sure you want to remove {enrollment.student} from {enrollment.subject}?",
			"confirm_label": "Delete Enrollment",
			"cancel_url": "/enrollments/",
		},
	)
