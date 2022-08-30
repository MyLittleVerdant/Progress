#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <fstream>
#include <string>

#define N 5
using namespace std;


class flight
{
private:
	char destination[20];
	int num;
	char type[10];
	double time;
	char date[15];

public:

	void schedule()
	{

		printf("%s %d %s %.2lf %s\t\n", destination, num, type, time, date);
	}

	void copy(char destintaion[], int num, char type[], double time, char date[])
	{
		strcpy(this->destination, destintaion);
		this->num = num;
		strcpy(this->type, type);
		this->time = time;
		strcpy(this->date, date);

	}

	bool compare(char destintaion[])
	{
		if (strcmp(this->destination, destintaion) == 0)
			return true;
		else return false;
	}
	bool comparestr(char day[])
	{
		bool flag = false;
		int size = strlen(this->date);
		int i = 0;
		for(int i=0;i<size-1;i++)
		{
			if (day[0] == this->date[i] && day[1] == this->date[i + 1])
			{
				return true;
				

			}
		}
		return false;
	}

	bool comparetime(double time)
	{
		if (time < this->time)
			return true;
		else return false;
	}
};

struct NotFoundException : public exception {
	const char* what() const throw () {
		return "No such destination \n";
	}
};

void sortdest(flight* arr)
{
	bool flag = false;
	char destination[20];
	cout << "Destination: ";
	cin >> destination;
	for (int i = 0; i < N; i++)
	{
		if (arr[i].compare(destination))
		{
			arr[i].schedule();
			flag = true;
		}

	}
	if (!flag)
		throw exception("No such destination\n");
		//cout << "No such destination " << endl;*/
}

void sortday(flight* arr)
{
	bool flag = false;
	char day[15];
	cout << "Day: ";
	cin >> day;
	if (strlen(day) < 3|| strcmp(day,"Sunday")==0|| strcmp(day, "Monday")==0|| strcmp(day, "Tuesday")==0 || strcmp(day, "Wednesday")==0 || strcmp(day, "Friday")==0 || strcmp(day, "Thursday")==0 || strcmp(day, "Saturday")==0 )
	{
		for (int i = 0; i < N; i++)
		{
			if (arr[i].comparestr(day))
			{
				arr[i].schedule();
				flag = true;
			}

		}
		if (!flag)
			cout << "There is no such day in the schedule " << endl;
	}else
		cout << "There is no such day in the schedule " << endl;
}

void sortdaytime(flight* arr)
{
	bool flag = false;
	char day[15];
	double time;
	do {
		cout << "Time: ";
		cin >> time;
	} while (time < 0.00 || time>24.00);
	cout << "Day: ";
	cin >> day;
	if (strlen(day) < 3 || strcmp(day, "Sunday") == 0 || strcmp(day, "Monday") == 0 || strcmp(day, "Tuesday") == 0 || strcmp(day, "Wednesday") == 0 || strcmp(day, "Friday") == 0 || strcmp(day, "Thursday") == 0 || strcmp(day, "Saturday") == 0)
	{
		for (int i = 0; i < N; i++)
		{
			if (arr[i].comparestr(day)&&arr[i].comparetime(time))
			{
				arr[i].schedule();
				flag = true;
			}

		}
		if (!flag)
			cout << "No flights meeting these conditions " << endl;
	}
	else
		cout << "There is no such day in the schedule " << endl;
}
void fill(flight *arr)
{
	int i = 0;
	char destination[20];
	int num;
	char type[10];
	double time;
	char date[15];
	FILE* file;
	file = fopen("file.txt", "rt");
	if (file)
	{
		while (!feof(file))
		{

			fscanf(file, "%s %d %s %lf %s", &destination, &num, &type, &time, &date);
			arr[i].copy(destination, num, type, time, date);
			i++;

		}
	}
	else
		cout << "File not found" << endl;
	
	fclose(file);
}




void main()
{
	bool exit = false;
	int c;
	flight *arr= new flight[N];
	fill(arr);
	for (int i=0; i < N; i++)
		arr[i].schedule();
	
	cout << endl;
	cout << "1.List of flights for a given destination" << endl << "2.List of flights for a given day of the week" << endl << "3.List of flights for a given day of the week whose departure time is greater than the specified one" << endl<<"4.Exit"<<endl;
	do {
		cin >> c;
		switch (c)
		{
		case 1:try { sortdest(arr); }
			   catch (const exception & e)
		{
			cout << e.what();
		}
			   break;
		case 2:sortday(arr); break;
		case 3:sortdaytime(arr); break;
		case 4:exit = true; break;

		}
	} while (!exit);
}