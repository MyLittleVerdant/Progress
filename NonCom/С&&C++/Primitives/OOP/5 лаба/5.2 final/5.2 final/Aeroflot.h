#pragma once
#include"Header.h"
using namespace std;

class Aeroflot
{
public:

	Aeroflot() {

	}

	int num;
	double time;
	string destination;
	string type;
	string date;

	Aeroflot(const Aeroflot& other)
	{
		this->num = other.num;
		this->time = other.time;
		this->destination = other.destination;
		this->type = other.type;
		this->date = other.date;

	}

	
	friend ostream& operator <<(ostream& out, const Aeroflot& obj)
	{

		out << obj.destination << " " << obj.num << " " << obj.type << " " << obj.time << " " << obj.date << endl;

		return out;
	}
};


