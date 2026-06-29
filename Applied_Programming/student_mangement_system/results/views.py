from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from .forms import ResultForm
from .models import Result
from django.contrib.auth.decorators import login_required
from django.contrib.auth.decorators import permission_required
from students.models import Student

@login_required
@permission_required("results.view_result")
def result_list(request):

    search_query = request.GET.get("search", "")

    # -----------------------------------
    # Student sees ONLY their own results
    # -----------------------------------
    if request.user.groups.filter(name="Student").exists():

        student = get_object_or_404(
            Student,
            user=request.user
        )

        results = Result.objects.select_related(
            "student",
            "exam",
            "subject",
            "exam__subject"
        ).filter(
            student=student
        )

    # -----------------------------------
    # Admin / Faculty see all results
    # -----------------------------------
    else:

        results = Result.objects.select_related(
            "student",
            "exam",
            "subject",
            "exam__subject"
        ).all()

        if search_query:

            results = results.filter(
                Q(student__full_name__icontains=search_query)
                | Q(student__roll_number__icontains=search_query)
                | Q(subject__subject_name__icontains=search_query)
                | Q(exam__exam_type__icontains=search_query)
                | Q(grade__icontains=search_query)
            ).distinct()

    paginator = Paginator(results, 10)

    page_number = request.GET.get("page")

    page_obj = paginator.get_page(page_number)

    return render(
        request,
        "results/result_list.html",
        {
            "results": page_obj,
            "page_obj": page_obj,
            "search_query": search_query,
        },
    )

@login_required
@permission_required("results.add_result")
def add_result(request):
	form = ResultForm(request.POST or None)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Result added successfully!")
		return redirect("result_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Add Result",
			"submit_label": "Save Result",
			"cancel_url": "/results/",
		},
	)

@login_required
@permission_required("results.change_result")
def edit_result(request, result_id):
	result = get_object_or_404(Result, result_id=result_id)
	form = ResultForm(request.POST or None, instance=result)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Result updated successfully!")
		return redirect("result_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Edit Result",
			"submit_label": "Update Result",
			"cancel_url": "/results/",
		},
	)

@login_required
@permission_required("results.delete_result")
def delete_result(request, result_id):
	result = get_object_or_404(Result, result_id=result_id)

	if request.method == "POST":
		result.delete()
		messages.success(request, "Result deleted successfully!")
		return redirect("result_list")

	return render(
		request,
		"shared/confirm_delete.html",
		{
			"title": "Delete Result",
			"message": f"Are you sure you want to delete the result for {result.student}?",
			"confirm_label": "Delete Result",
			"cancel_url": "/results/",
		},
	)
