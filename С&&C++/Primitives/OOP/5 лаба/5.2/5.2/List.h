#pragma once
#ifndef LIST_H
#define LIST_H
#define _CRT_SECURE_NO_WARNINGS
#include <fstream>
#include <iostream>
using namespace std;

class List;
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

	friend List;
	//friend ostream& operator <<(ostream& out, const Aeroflot& obj);
};
/*ostream& operator <<(ostream& out, const Aeroflot& obj)
{

	out << obj.destination << " " << obj.num << " " << obj.type << " " << obj.time << " " << obj.date  << endl;

	return out;
}*/


class List
{

	class Node
	{
	public:
		Aeroflot flight;
		Node* Next, * Prev;
		/*ostream& operator <<(ostream& out)
		{
				out << flight << endl << endl;
			return out;
		}*/
	};
	int count;
	Node* Head, * Tail;
public:
	friend Aeroflot;
	//friend ostream& operator <<(ostream& out, Node* Head);
	List();
	~List();
	List(const List& other);
	Node* begin()
	{
		return Head;
	}
	Node* end()
	{
		return Tail;
	}
	
	//void Delete(int position);
	void Add(Aeroflot &flight);
	void Show();
	void fill(string name);
	void clear();
	int getSize();
	
	/*ostream& operator <<(ostream& out)
	{
		Node* temp = Head;
		for (int i = 0; i < count; i++)
		{
			out << temp->flight << endl << endl;
			temp = temp->Next;

		}
		return out;
	}*/
	
};



#endif 
