#include <iostream> 

using namespace std;
class time
{
	int hours;
	int min;
public:
	int enter()
	{
		int a, b;
		double temp;
		do {
			cin >> temp;
			a = (int)temp;
		    b = (temp - a) * 100;
			if (temp < 0 || temp>24||b>60)
				cout << "Incorrect input"<<endl;
			else {
				
					this->hours = a;
					this->min = b;
				
			}
		} while (temp < 0 || temp>24 || b > 60);
		return 0;

	}

	void schedule(time start,time end)
	{
		bool cont = true;
		time check;
		cout << fixed;
		cout.precision(2);
		cout << "Start-" << start.hours << ":";
		if (start.min == 0) cout << "00"; 
		else if (start.min < 10 && start.min>0) cout << "0" << start.min; else cout << start.min;
		cout << "\t" << "End-" << end.hours << ":";if (end.min == 0) cout << "00"; 
		else if (end.min < 10 && end.min>0) cout << "0" << end.min; else  cout << end.min;
		cout<< endl << endl << "Schedule:" << endl;
		do {
			cout << start.hours << ":"; if (start.min == 0) cout << "00";
			else if (start.min < 10&& start.min>0) cout << "0" << start.min; else cout << start.min;cout << "-";
			start.min += 45;
			if (start.min >= 60)
			{
				start.hours++;
				start.min -= 60;
			}
			cout << start.hours << ":"; if (start.min == 0) cout << "00"; 
			else if (start.min < 10 && start.min>0) cout << "0" << start.min; else cout << start.min; cout << endl;
			start.min += 10;
			if (start.min >= 60)
			{
				start.hours++;
				start.min -= 60;
			}
			check = start;
			check.min += 45;
			if (check.min >= 60)
			{
				check.hours++;
				check.min -= 60;
			}
			if (check.hours > end.hours)
				cont = false;
			else if (check.hours == end.hours)
			{
				if(check.min >= end.min)
					cont = false;
			}
			
		} while (cont);
	}

};

void main()
{
	time start;
	time end;
	cout << "Enter start time and end time:"<<endl;
	start.enter();
	end.enter();
	start.schedule(start, end);

}